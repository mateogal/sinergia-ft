<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\TeamMakerController;
use App\Http\Resources\MatchResource;
use App\Models\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = Match::all();
        return response([ 'matches' => MatchResource::collection($matches), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'date' => 'required',
            'res_t1' => 'required',
            'res_t2' => 'required',
            'field_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $match = Match::create($data);

        return response(['match' => new MatchResource($match), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
        foreach ($match->player_match as $players){
            $players->player;
        }
        return response(['match' => new MatchResource($match), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        $match->update($request->all());

        return response(['match' => new MatchResource($match), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        $match->delete();

        return response(['message' => 'Deleted']);
    }

    public function nextMatch(){
        // $teamMaker = new TeamMakerController;
        $today = date('Y-m-d');
        $next = Match::get()->where('date', '>=', $today);
        if (count($next) == 0){
            return response(['error' => 'Sin datos'], 400);
        }

        // $data = new Request();
        foreach( $next as $match){
            $match->field;
            // $data->query->add(['match_id' => $match->id]);
            // $match['teams'] = ($teamMaker->bestLineUps($data))->original['teams'];
            $team1 = $match->player_match()->where('team_type', 'team1')->get();
            $team2 =$match->player_match()->where('team_type', 'team2')->get();
            $team1_data = $team2_data = array();
            foreach ($team1 as $player){
                array_push($team1_data, ['name' => $player->player->name." ".$player->player->lastname, 'avg' => ($player->player->offense + $player->player->defense)/2]);
            }
            foreach ($team2 as $player){
                array_push($team2_data, ['name' => $player->player->name." ".$player->player->lastname, 'avg' => ($player->player->offense + $player->player->defense)/2]);
            }
            $match['teams'] = array(
                'team1' => $team1_data,
                'team2' => $team2_data
            );
        }



        return response(['match' => new MatchResource($next), 'message' => 'Retrieved successfully'], 200);
    }

    public function history(){
        $matches = Match::where('finished', true)->get();
        foreach($matches as $match){
            $match->field;
        }
        return response([ 'matches' => MatchResource::collection($matches), 'message' => 'Retrieved successfully'], 200);
    }
}
