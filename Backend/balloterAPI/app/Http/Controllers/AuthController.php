<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Person;
use App\Models\Address;
use App\Models\Institution;
use App\Models\Role;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class AuthController extends Controller
{
    const PASSWORD_REGEX = '/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // TODO: solve auth/only
        $this->middleware('auth', ['only' => [
            'logout',
            'showAll',
            'showOne',
            'update',
            'updatePassword',
            'delete'
        ]]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|email',
            'password' => 'required'
        ]);
        $username = User::normalizeUserName($request->input('username'));
        $user = User::where('username', $username)->first();
        if (empty($user))
        {
            return response()->json(['message' => 'invalidCredentials'], 401);
        }
        if (!$user->isPasswordCorrect($request->input('password')))
        {
            return response()->json(['message' => 'invalidCredentials'], 401);
        }
        try {
            $user->setApiToken();
            $user->setRole(); // TODO: vyřešit elegantněji
            $user->id_token = $user->api_token;
            // Needs key in header called Authorization with the value of the token
            return response()->json($user, 200)
                ->header('Authorization', 'Bearer '.$user->api_token)
                ->header('Access-Control-Expose-Headers', 'Authorization');
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        if(Auth::check()){
            $user = Auth::user();
          }

        if (empty($user))
        {
            return response()->json(['message' => 'invalidCredentials'], 401);
        }
        try {
            $user->update([
                    'api_token' => null
            ]);
            return response()->json(['message' => 'logoutSuccessful'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            /*
             * temporary workaround
             */
            //'person_id' => 'required',
            'username' => 'required|email',
            'password' => 'required|min:8|confirmed|regex:'.self::PASSWORD_REGEX
        ]);

        try {
            $hasher = app()->make('hash');
            $password = $hasher->make($request->input('password'));
            // TODO: refactor You may pass a default value as the second argument to the input method. This value will be returned if the requested input value is not present on the request: $name = $request->input('name', 'Sally');
            $preferredLocale = $request->input('preferred_locale');
            $username = User::normalizeUserName($request->input('username'));

            $user = User::create([
                'username' => $username,
                'password' => $password
            ]);
            if (!empty($preferredLocale)) {
                $user->update([
                    'preferred_locale' => $preferredLocale
                ]);
            }
            return response()->json($user, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            if (23000 == $e->getCode() || 23505 == $e->getCode()) {
                return response()->json(['username' => ['validation.unique']], 409);
            } else {
                $code = 500;
                $message = $e->getMessage();
            }
            return response()->json(['message' => $message], $code);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $person = Person::find($user->person);
            $persons = [];

            //Only let authenticated user delete their account
            if(Auth::user()->id != $id) return response()->json(['message' => 'Unauthorized'], 401);

            $user->delete();
            if($person != null)
            {
                //if the user has personal infor with address that isn't used by other users, delete that too
                $address = Address::find($person->address);
                if ($address != null) $persons = Person::where('address', $address->id, false)->get();

                $person->delete();
                if(sizeof($persons) == 1) $address->delete();
            }

            DB::commit();
            return response()->json(['message' => 'Deleted successfully.'], 204);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function showOne($id)
    {
        $user = User::find($id);
        $this->authorize('showOne', $user, Auth::user());
        $user->setRole();
        $return_value = array(
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'api_token' => $user->api_token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        );
        return response()->json($return_value);
    }

    public function returnUser(){
        if(Auth::check()){
            $user = Auth::user();
            $person = Person::find($user->person);
            $role = Role::find($user->role);
            $address = null;
            $institution = null;
            if($person != null){
                $address = Address::find($person->address);
                $institution = Institution::find($person->institution);
                if($institution != null) {
                    $instAddress = Address::find($institution->address);
                    $institution->address = $instAddress;
                }
                $person->address = $address;
                $person->institution = $institution;
            }


          }
          else return response()->json(['message' => 'Unauthorized'], 401);
          $return_value = array(
            'id' => $user->id,
            'username' => $user->username,
            'person' => $person,
            'api_token' => $user->api_token,
            'preferred_locale' => $user->preferred_locale,
            'role' => $role,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        );

        return response()->json($return_value);
    }
}
