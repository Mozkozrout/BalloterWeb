<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Address;
use App\Models\Institution;
use Illuminate\Support\Facades\DB;
use Auth;

class PersonController extends Controller
{

    public function __construct()
    {
        // TODO: solve auth/only
        $this->middleware('auth', ['only' => [
            'create',
            'update',
            'delete',
            'showOne',
            'returnInstitutions',
        ]]);
    }

    //Person creation
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
        ]);

            $data = $request->only(['name', 'surname', 'birthdate', 'id_number', 'note', 'institution']);
            $data['id_number'] = rand(100000000, 999999999);

            try
            {
                DB::beginTransaction();

                //only users with now personal info can create it
                if(Auth::user()->person != null)
                {
                    return response()->json(['message' => 'User personal profile already exists'], 500);
                }
                //creation of new address in case user has filled it in
                if($request->input('address') != null)
                {
                    $this->validate($request, [
                        'address.state' => 'required',
                        'address.city' => 'required',
                        'address.street' => 'required',
                        'address.house_nmr' => 'required',
                        'address.zip' => 'required',
                    ]);
                    $address = Address::firstOrCreate($request->input('address'));
                    $data['address'] = $address->id;
                }
                $person = Person::create($data);
                $user = Auth::user();
                $user->setPerson($person->id);
                $user->save();

                DB::commit();
                return response()->json($data);
                return response()->json($person, 201);
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage()], 500);
            }


    }

    //Person data update
    public function update($id, Request $request)
    {
        $data = $request->only(['name', 'surname','birthdate','institution','note']);

        try
        {
            DB::beginTransaction();
            $person = Person::findOrFail($id);

            try
            {
                //if the request has an address it gets updated if not, the address gets deleted unless user didn't have one
                if($request->input('address') != null){
                    $address = Address::firstOrCreate($request->input('address'));
                    $data['address'] = $address->id;
                    $person->update($data);
                }else{
                    $data['address'] = null;
                    $address = Address::find($person->address);
                    $person->update($data);
                    if($address != null) $address->delete();
                }

                DB::commit();
                return response()->json($person, 200);
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 404);
        }
    }

    public function delete($id)
    {
        try {
            $person = Person::findOrFail($id);
            $user = Auth::user();
            try
            {
                DB::beginTransaction();

                //Only let users delete their own personal info
                if($user->person == null || $user->person != $id) return response()->json(['message' => 'Unauthorized'], 401);

                $user->setPerson(null);
                $user->save();
                $persons = [];

                //if there is address in the personal info, delete that too
                $address = Address::find($person->address);
                if ($address != null) $persons = Person::where('address', $address->id, false)->get();

                $person->delete();
                if(sizeof($persons) == 1) $address->delete();

                DB::commit();
                return response()->json(['message' => 'Deleted successfully.'], 204);
            } catch (\Illuminate\Database\QueryException $e)
            {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 404);
        }
    }

    public function returnInstitutions()
    {
        return response()->json(Institution::all());
    }
}
