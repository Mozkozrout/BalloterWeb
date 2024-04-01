<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Motion;
use App\Models\Person;
use Auth;

class MotionController extends Controller
{

    public function __construct()
    {
        // TODO: solve auth/only
        $this->middleware('auth', ['only' => [
            'create',
            'update',
            'delete'
        ]]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

            $data = $request->all();
            $person_id = Auth::user()->person;

            try
            {
                if($person_id != null){
                    $data['added_by'] = $person_id;
                    $motion = Motion::create($data);
                    return response()->json($motion, 201);
                }else{
                    return response()->json(['message' => 'No Person Data'], 500);
                }
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                return response()->json(['message' => $e->getMessage()], 500);
            }


    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $person_id = Auth::user()->person;

        try
        {
            //this needs fixing
            $motion = Motion::findOrFail($id);
            if($person_id == null) return response()->json(['message' => 'No Person Data'], 500);
            if($person_id != $motion->added_by) return response()->json(['message' => 'Unauthorized'], 401);
            try
            {
                $data['edited_by'] = $person_id;
                $motion->update($data);
                return response()->json($motion, 200);
            }
            catch (\Illuminate\Database\QueryException $e)
            {
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
            $motion = Motion::findOrFail($id);
            $person_id = Auth::user()->person;

            if($person_id == null) return response()->json(['message' => 'No Person Data'], 500);
            if($person_id != $motion->added_by) return response()->json(['message' => 'Unauthorized'], 401);
            try
            {
                $motion->delete();
                return response()->json(['message' => 'Deleted successfully.'], 204);
            } catch (\Illuminate\Database\QueryException $e)
            {
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 404);
        }
    }

    public function showOne($id)
    {
        $motion = Motion::find($id);
        $added_by = Person::find($motion->added_by);
        $edited_by = Person::find($motion->edited_by);
        //Maybe this shouldn't return the whole person with all of his data
        $motion->edited_by = $edited_by;
        $motion->added_by = $added_by;
        return response()->json($motion, 200);
    }

    public function showAll()
    {
        $motions = [];
        foreach(Motion::all() as $motion){
            $added_by = Person::find($motion->added_by);
            $edited_by = Person::find($motion->edited_by);

            $motion->edited_by = $edited_by;
            $motion->added_by = $added_by;

            array_push($motions, $motion);
        }
        return response()->json($motions);
    }
}
