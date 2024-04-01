<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Arr;

use App\Models\Ballot;
use App\Models\Event;
use App\Models\Motion;
use App\Models\Team;
use App\Models\Person;
use App\Models\Institution;
use App\Models\Address;
use App\Models\User;
use App\Models\Role;


class BallotController extends Controller
{

    public function __construct()
    {
        // TODO: solve auth/only
        $this->middleware('auth', ['only' => [
            'showAll',
            'showOne',
            'showMine',
            'create',
            'update',
            'delete',
            'createPDF',
            'returnTeams',
            'returnTournaments',
        ]]);
    }

    //function that creates a PDF file out of a blade template
    public function createPDF($id){
        $ballot =  Ballot::find($id);
        $ballot = $this->ballotDataFill($ballot);
        $A1 = null;
        $A2 = null;
        $A3 = null;
        $N1 = null;
        $N2 = null;
        $N3 = null;
        $judges = '';
        $best_speaker = null;

        foreach($ballot['People'] as $person){
            $person['points_sum'] = $person['cont_points'] + $person['str_points'] + $person['style_points'] + $person['cq_points'];
            if($person['best_speaker'] == 1) $best_speaker = $person;
            switch ($person['role']) {
                case 'A1':
                  $A1 = $person;
                  if($person['cq_points'] > 0) $A1['cq_points'] = '+' . $A1['cq_points'];
                  $ballot['Ballot']['team_AFF']['points_sum'] += $person['points_sum'];
                  break;
                case 'A2':
                  $A2 = $person;
                  if($person['cq_points'] > 0) $A2['cq_points'] = '+' . $A2['cq_points'];
                  $ballot['Ballot']['team_AFF']['points_sum'] += $person['points_sum'];
                  break;
                case 'A3':
                  $A3 = $person;
                  if($person['cq_points'] > 0) $A3['cq_points'] = '+' . $A3['cq_points'];
                  $ballot['Ballot']['team_AFF']['points_sum'] += $person['points_sum'];
                  break;
                case 'N1':
                  $N1 = $person;
                  if($person['cq_points'] > 0) $N1['cq_points'] = '+' . $N1['cq_points'];
                  $ballot['Ballot']['team_NEG']['points_sum'] += $person['points_sum'];
                  break;
                case 'N2':
                  $N2 = $person;
                  if($person['cq_points'] > 0) $N2['cq_points'] = '+' . $N2['cq_points'];
                  $ballot['Ballot']['team_NEG']['points_sum'] += $person['points_sum'];
                  break;
                case 'N3':
                  $N3 = $person;
                  if($person['cq_points'] > 0) $N3['cq_points'] = '+' . $N3['cq_points'];
                  $ballot['Ballot']['team_NEG']['points_sum'] += $person['points_sum'];
                  break;
                case 'Adjudicator':
                  if ($judges == '') {
                    $judges .=
                      $person['person_id']['name'] . ' ' . $person['person_id']['surname'];
                  } else
                  $judges .= ', ' .
                  $person['person_id']['name'] . ' ' . $person['person_id']['surname'];
                  break;
              }


        }

        //I might count the number of characters for each table and make certain breakpoints for new pages so that the tables won't break
        $pdf = Pdf::loadView('ballotPDF',
        [
          'ballot' => $ballot,
          'A1' => $A1,
          'A2' => $A2,
          'A3' => $A3,
          'N1' => $N1,
          'N2' => $N2,
          'N3' => $N3,
          'judges' => $judges,
          'best_speaker' => $best_speaker,
        ]);
        return $pdf->download('ballot.pdf');
    }

    //Creates a new ballot
    public function create(Request $request)
    {
        $this->validate($request, [
            'tournament' => 'required',
            'date' => 'required',
            'motion' => 'required',
            'team_AFF' => 'required',
            'team_NEG' => 'required',
            'decision' => 'required',
            'adj_winning_team' => 'required',
            'winning_team' => 'required',
            'adjucations' => 'required',
            'pivot' => 'required',
            'pivot.Adjudicator' => 'required',
            'pivot.Adjudicator.id' => 'required',
            'pivot.A1' => 'required',
            'pivot.A1.*' => 'required',
            'pivot.A2' => 'required',
            'pivot.A2.*' => 'required',
            'pivot.A3' => 'required',
            'pivot.A3.*' => 'required',
            'pivot.N1' => 'required',
            'pivot.N1.*' => 'required',
            'pivot.N2' => 'required',
            'pivot.N2.*' => 'required',
            'pivot.N3' => 'required',
            'pivot.N3.*' => 'required',
        ]);

            $data = $request->only(['tournament', 'date', 'motion', 'team_AFF', 'team_NEG', 'decision', 'adj_winning_team', 'winning_team', 'adjucations']);

            DB::beginTransaction();
            try
            {
                $ballot = Ballot::create($data);

                foreach($request->input('pivot') as $role)
                {
                    $ballot->persons()->attach($role['id'],[
                        'role' => $role['role'],
                        'comment' => $role['comment'],
                        'cont_points' => $role['cont_points'],
                        'str_points' => $role['str_points'],
                        'style_points' => $role['style_points'],
                        'cq_points' => $role['cq_points'],
                        'best_speaker' => $role['best_speaker'],
                        'author' => $role['author']
                    ]);
                }

                DB::commit();

                $pivot = [];
                foreach($ballot->persons as $person) array_push($pivot, $person->debate);
                return response()->json([$ballot, $pivot], 201);
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage()], 500);
            }


    }

    //Updates a ballot
    public function update($id, Request $request)
    {
        $data = $request->only(['tournament', 'date', 'motion', 'team_AFF', 'team_NEG', 'decision', 'adj_winning_team', 'winning_team', 'adjucations']);

        DB::beginTransaction();
        try
        {
            $ballot = Ballot::findOrFail($id);

            try
            {
                $ballot->update($data);

                foreach($request->input('pivot') as $role)
                {
                    $ballot->persons()->updateExistingPivot($role['id'],[
                        'role' => $role['role'],
                        'comment' => $role['comment'],
                        'cont_points' => $role['cont_points'],
                        'str_points' => $role['str_points'],
                        'style_points' => $role['style_points'],
                        'cq_points' => $role['cq_points'],
                        'best_speaker' => $role['best_speaker'],
                        'author' => $role['author']
                    ]);
                }

                DB::commit();
                $pivot = [];
                foreach($ballot->persons as $person) array_push($pivot, $person->debate);
                return response()->json([$ballot, $pivot], 200);
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

    //Deletes a ballot
    public function delete($id)
    {
        try {
            $ballot = Ballot::findOrFail($id);
            DB::beginTransaction();
            try
            {
                $ballot->persons()->detach();
                $ballot->delete();

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

    //Return one Ballot
    public function showOne($id)
    {
        $ballot =  Ballot::find($id);
        return response()->json($this->ballotDataFill($ballot));
    }

    //Returns all Ballots - probably should be admin only
    public function showAll()
    {
        if (Person::find(Auth::user()->person)->user->isAdmin() != 'admin'){
            response()->json(['message' => 'Unauthorized'], 401);
        }

        $return_value = [];

        foreach(Ballot::all() as $ballot) array_push($return_value, $this->ballotDataFill($ballot));

        return response()->json($return_value);
    }

    //Returns only the ballots user is involved in
    public function showMine()
    {
        $return_value = [];

        foreach(Ballot::all() as $ballot) {
            foreach($ballot->persons as $person){
                if($person->id == Auth::user()->person) array_push($return_value, $this->ballotDataFill($ballot));
            }
        }

        return response()->json($return_value);
    }

    //Function for filling ballot with all the necessary data from all the different tables
    private function ballotDataFill($ballot){
        //It is possible to uncomment a line if the data is deemed important to have
        $people = [];

        $fullBallot = array(
            'id' => $ballot->id,
            'tournament' => Event::find($ballot->tournament),
            'date' => $ballot->date,
            'motion' => Motion::find($ballot->motion),
            'team_AFF' => Team::find($ballot->team_AFF),
            'team_NEG' => Team::find($ballot->team_NEG),
            'decision' => $ballot->decision,
            'adj_winning_team' => Team::find($ballot->adj_winning_team),
            'winning_team' => Team::find($ballot->winning_team),
            'adjucations' => $ballot->adjucations,
            'created_at' => $ballot->created_at,
            'updated_at' => $ballot->updated_at,
        );

            //Tournament
        $fullBallot['tournament']['institution'] = Institution::find($fullBallot['tournament']['institution']);
        #$fullBallot['tournament']['institution']['address'] = Address::find($fullBallot['tournament']['institution']['address']);

            //Motion Added by
        $fullBallot['motion']['added_by'] = Person::find($fullBallot['motion']['added_by']);
        #$fullBallot['motion']['added_by']['institution'] = Institution::find($fullBallot['motion']['added_by']['institution']);
        #$fullBallot['motion']['added_by']['institution']['address'] = Address::find($fullBallot['motion']['added_by']['institution']['address']);
        #$fullBallot['motion']['added_by']['address'] = Address::find($fullBallot['motion']['added_by']['address']);

            //Motion Edited by
        $fullBallot['motion']['edited_by'] = Person::find($fullBallot['motion']['edited_by']);
        if($fullBallot['motion']['edited_by'] != null)
        {
            #$fullBallot['motion']['edited_by']['institution'] = Institution::find($fullBallot['motion']['edited_by']['institution']);
            #$fullBallot['motion']['edited_by']['institution']['address'] = Address::find($fullBallot['motion']['edited_by']['institution']['address']);
            #$fullBallot['motion']['edited_by']['address'] = Address::find($fullBallot['motion']['edited_by']['address']);
        }

            //Team Affirmation
        $fullBallot['team_AFF']['institution'] = Institution::find($fullBallot['team_AFF']['institution']);
        #$fullBallot['team_AFF']['institution']['address'] = Address::find($fullBallot['team_AFF']['institution']['address']);
        $fullBallot['team_AFF']['registered_by'] = User::find($fullBallot['team_AFF']['registered_by']);
        $fullBallot['team_AFF']['registered_by']['person'] = Person::find($fullBallot['team_AFF']['registered_by']['person']);
        #$fullBallot['team_AFF']['registered_by']['person']['institution'] = Institution::find($fullBallot['team_AFF']['registered_by']['person']['institution']);
        #$fullBallot['team_AFF']['registered_by']['person']['institution']['address'] = Address::find($fullBallot['team_AFF']['registered_by']['person']['institution']['address']);
        #$fullBallot['team_AFF']['registered_by']['person']['address'] = Address::find($fullBallot['team_AFF']['registered_by']['person']['address']);
        #$fullBallot['team_AFF']['registered_by']['role'] = Role::find($fullBallot['team_AFF']['registered_by']['role']);
        $fullBallot['team_AFF']['team_members'] = $fullBallot['team_AFF']->teamMembers->intersect($ballot->persons)->all(); //This should only return those team members that were in the debate

            //Team Negation
        $fullBallot['team_NEG']['institution'] = Institution::find($fullBallot['team_NEG']['institution']);
        #$fullBallot['team_NEG']['institution']['address'] = Address::find($fullBallot['team_NEG']['institution']['address']);
        $fullBallot['team_NEG']['registered_by'] = User::find($fullBallot['team_NEG']['registered_by']);
        $fullBallot['team_NEG']['registered_by']['person'] = Person::find($fullBallot['team_NEG']['registered_by']['person']);
        #$fullBallot['team_NEG']['registered_by']['person']['institution'] = Institution::find($fullBallot['team_NEG']['registered_by']['person']['institution']);
        #$fullBallot['team_NEG']['registered_by']['person']['institution']['address'] = Address::find($fullBallot['team_NEG']['registered_by']['person']['institution']['address']);
        #$fullBallot['team_NEG']['registered_by']['person']['address'] = Address::find($fullBallot['team_NEG']['registered_by']['person']['address']);
        #$fullBallot['team_NEG']['registered_by']['role'] = Role::find($fullBallot['team_NEG']['registered_by']['role']);
        $fullBallot['team_NEG']['team_members'] = $fullBallot['team_NEG']->teamMembers->intersect($ballot->persons)->all(); //This should only return those team members that were in the debate

            //Adjudicator's winning team
        #$fullBallot['adj_winning_team']['institution'] = Institution::find($fullBallot['adj_winning_team']['institution']);
        #$fullBallot['adj_winning_team']['institution']['address'] = Address::find($fullBallot['adj_winning_team']['institution']['address']);
        #$fullBallot['adj_winning_team']['registered_by'] = User::find($fullBallot['adj_winning_team']['registered_by']);
        #$fullBallot['adj_winning_team']['registered_by']['person'] = Person::find($fullBallot['adj_winning_team']['registered_by']['person']);
        #$fullBallot['adj_winning_team']['registered_by']['person']['institution'] = Institution::find($fullBallot['adj_winning_team']['registered_by']['person']['institution']);
        #$fullBallot['adj_winning_team']['registered_by']['person']['institution']['address'] = Address::find($fullBallot['adj_winning_team']['registered_by']['person']['institution']['address']);
        #$fullBallot['adj_winning_team']['registered_by']['person']['address'] = Address::find($fullBallot['adj_winning_team']['registered_by']['person']['address']);
        #$fullBallot['adj_winning_team']['registered_by']['role'] = Role::find($fullBallot['adj_winning_team']['registered_by']['role']);

            //Winning team
        #$fullBallot['winning_team']['institution'] = Institution::find($fullBallot['winning_team']['institution']);
        #$fullBallot['winning_team']['institution']['address'] = Address::find($fullBallot['winning_team']['institution']['address']);
        #$fullBallot['winning_team']['registered_by'] = User::find($fullBallot['winning_team']['registered_by']);
        #$fullBallot['winning_team']['registered_by']['person'] = Person::find($fullBallot['winning_team']['registered_by']['person']);
        #$fullBallot['winning_team']['registered_by']['person']['institution'] = Institution::find($fullBallot['winning_team']['registered_by']['person']['institution']);
        #$fullBallot['winning_team']['registered_by']['person']['institution']['address'] = Address::find($fullBallot['winning_team']['registered_by']['person']['institution']['address']);
        #$fullBallot['winning_team']['registered_by']['person']['address'] = Address::find($fullBallot['winning_team']['registered_by']['person']['address']);
        #$fullBallot['winning_team']['registered_by']['role'] = Role::find($fullBallot['winning_team']['registered_by']['role']);


            //Reading data for the different debate participants
        foreach($ballot->persons as $person) {

            $fullPerson = $person->debate;

                //Person data
            $fullPerson->person_id = Person::find($fullPerson->person_id);

                //Institution
            #$fullPerson->person_id->institution = Institution::find($fullPerson->person_id->institution);

                //Institution Address
            if($fullPerson->person_id->institution != null){
                #$fullPerson->person_id->institution->address = Address::find($fullPerson->person_id->institution->address);
            }

                //Person Address
            if($fullPerson->person_id->address != null){
                #$fullPerson->person_id->address = Address::find($fullPerson->person_id->address);
            }

            array_push($people, $fullPerson);
        }


        return ['Ballot' => $fullBallot, 'People' => $people];
    }

    //function that returns all teams with added tournament value
    public function returnTeams(){
        $teams = [];
        foreach(Team::all() as $team){
            $team->events;
            $team->teamMembers;
            array_push($teams, $team);
        }
        return response()->json($teams);
    }

    //function that returns all tournaments with added institution value
    public function returnTournaments(){
        $events = [];
        foreach(Event::all() as $event){
            $event['institution'] = Institution::find($event['institution']);
            array_push($events, $event);
        }
        return response()->json($events);
    }
}
