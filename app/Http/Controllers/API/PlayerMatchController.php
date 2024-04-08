<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\TeamMakerController;
use App\Http\Resources\PlayerMatchResource;
use App\Models\PlayerMatch;
use App\Models\Player;
use App\Models\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PlayerMatchController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $player_id = $request->user()->id;
        $data['player_id'] = $player_id;

        $validator = Validator::make($data, [
            'match_id' => 'required',
            'player_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        $playerCount = PlayerMatch::get()->where('match_id', $data['match_id'])->count();
        $matchInfo = Match::find($data['match_id']);

        if ($playerCount >= $matchInfo->max_players){
            return response(['error' => 'Se ha alcanzado el maximo de jugadores'], 400);
        }

        if (DB::table('player_match')->where([ ['player_id', $player_id], ['match_id', $data['match_id']] ])->exists()) {
            return response(['error' => 'Ya estas registrado al partido'], 400);
        }

        $makerObj = new TeamMakerController;
        $lineup = $makerObj->bestLineUps($request);

        $data['team_type'] = $lineup->original['new'];
        $data['goals'] = 0;
        $data['perf_o'] = 0;
        $data['perf_d'] = 0;
        $playermatch = PlayerMatch::create($data);
        return response(['playermatch' => new PlayerMatchResource($playermatch), 'message' => 'Created successfully', 'lineup' => $lineup->original], 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlayerMatch  $playerMatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayerMatch $playerMatch)
    {
        $player_id = $request->attributes->get('auth')['id'];
        // print_r($request->attributes);
        $request->request->add(['player_id' => $player_id]);
        print_r($request->all());

        $playerMatch->update($request->all());

        // return response(['playermatch' => new PlayerMatchResource($playermatch), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlayerMatch  $playerMatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $player_id = $request->attributes->get('auth')['id'];
        $request->request->add(['player_id' => $player_id]);
        $data = DB::table('player_match')
                            ->where('match_id', $request['match_id'])
                            ->where('player_id', $request['player_id'])
                            ->first();
        if (!$data){
            return response(['playermatch' => new PlayerMatchResource($request->all()), 'error' => 'No estas registrado al partido'], 400);
        }
        $delete = DB::table('player_match')
                    ->where('match_id', $request['match_id'])
                    ->where('player_id', $request['player_id'])
                    ->delete();
        if ($delete){
            return response(['playermatch' => new PlayerMatchResource($request->all()), 'message' => 'Deleted successfully'], 200);
        }else{
            return response(['playermatch' => new PlayerMatchResource($request->all()), 'error' => $delete], 400);
        }
    }

    public function getByPlayer($player_id)
    {
        $res = PlayerMatch::where('player_id', $player_id)->get();

        return $res;
    }

    public function ranking(Request $request){
        $playermatch = DB::table('player_match')
            ->select(DB::raw('player_id, sum(goals) as goals, sum(assists) as assists '))
            ->groupBy('player_id')
            ->orderBy('goals', 'desc')
            ->cursor();

        foreach($playermatch as $rank){
            $player = Player::find($rank->player_id);
            $victory_count = $this->victoryCount($rank->player_id);
            $wm_percentage = ($victory_count->total != 0) ? (int)(($victory_count->victory * 100) / $victory_count->total) : 0;
            $goals_avg = ($victory_count->total != 0) ? (int)($rank->goals/$victory_count->total) : 0;
            $assists_avg = ($victory_count->total != 0) ? (int)($rank->assists/$victory_count->total) : 0;
            $total_avg = $victory_count->points + $goals_avg + $assists_avg;
            $ranking[] = (object)[
                'player' => $player->name.' '.$player->lastname,
                'photo' => $player->photo,
                'goals' => $rank->goals,
                'assists' => $rank->assists,
                'total_games' => $victory_count->total,
                'victory' => $victory_count->victory,
                'lose' => $victory_count->lose,
                'draw' => $victory_count->draw,
                'points' => $victory_count->points,
                'goals_avg' => $goals_avg,
                'assists_avg' => $assists_avg,
                'wm' => $wm_percentage,
                'total_avg' => $total_avg
            ];
        }

        if ($request->routeIs('ranking')){
            $ranking = collect($ranking);
            $rankAssists = $ranking->sortByDesc('assists');
            $rankAvg = $ranking->sortByDesc('total_avg');
            return response(['ranking' => new PlayerMatchResource($ranking), 'rankAssists' => new PlayerMatchResource($rankAssists), 'rankAvg' => new PlayerMatchResource($rankAvg) ,'message' => 'Retrieved successfully'], 200);
        }else{
            $ranking = (collect($ranking)->sortByDesc('points'))->values();
            return $ranking;
        }
    }

    public function victoryCount($player_id){
        $played = PlayerMatch::where('player_id', $player_id)->get();
        $victory = 0;
        $draw = 0;
        $lose = 0;
        $points = 0;
        $total_played = 0;

        foreach($played as $match)
        {
            $matches = Match::where('id', $match->match_id)->first();
            if (isset($matches) && $matches->finished == 1){
                $total_played++;
                if ($match->team_type == 'team2' && ($matches->res_t2 > $matches->res_t1))
                {
                    $victory++;
                    $points += 3;
                }else if ($match->team_type == 'team1' && ($matches->res_t2 < $matches->res_t1)){
                    $victory++;
                    $points += 3;
                }else if ($matches->res_t1 == $matches->res_t2){
                    $draw++;
                    $points += 1;
                }else{
                    $lose++;
                }
            }
        }

        $array = (object)([
            'total' => $total_played,
            'victory' => $victory,
            'lose' => $lose,
            'draw' => $draw,
            'points' => $points
        ]);
        return $array;
    }

    public function getTeamsMatch(){
        $info = PlayerMatch::where('match_id', 7)->get();
        print_r($info);
    }
}
