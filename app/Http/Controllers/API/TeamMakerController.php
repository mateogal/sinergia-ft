<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamMakerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Player;
use App\Models\Match;
use App\Models\PlayerMatch;
use Auth;

class TeamMakerController extends Controller
{
    public function bestLineUps(Request $request)
    {
        $data = $request->all();

        if (!isset($data['match_id'])){
            return response(['error' => 'No se encontró el partido'], 400);
        }

        if (Auth::guard('api')->check()){
            $player_id = Auth::guard('api')->user()->id;
        }

        if (isset($player_id) && DB::table('player_match')->where([ ['player_id', $player_id], ['match_id', $data['match_id']] ])->exists()) {
            return response(['error' => 'Ya estas registrado al partido'], 400);
        }

        $i = 0;
        $match = Match::find($data['match_id']);

        $players = PlayerMatch::get()->where('match_id', $data['match_id']);

        $playerAvg = collect();
        foreach ($players as $player){
            $playerinfo = Player::find($player->player_id);
            $avg = collect(['id' => $playerinfo->id ,'name' => $playerinfo->name, 'avg' => ($playerinfo->offense + $playerinfo->defense) / 2]);
            $playerAvg = $playerAvg->put($playerinfo->id, $avg)->sortByDesc('avg');
        }

        if (isset($player_id)){
            $newPlayer = Player::find($player_id);
            $newPlayerAvg = collect(['id' => $newPlayer->id ,'name' => $newPlayer->name, 'avg' => ($newPlayer->offense + $newPlayer->defense) / 2]);
            $playerAvg = $playerAvg->put($newPlayer->id, $newPlayerAvg)->sortByDesc('avg');
        }

        $teams = collect();
        $player_per_team = (int)($playerAvg->count()/$match->teams_qty);

        $j = 0;
        for ($i=0; $i < $match->teams_qty; $i++) {
            $teams->put('team'.($i+1), collect());
        }

        $check = 'desc';
        while ($j < $player_per_team && $playerAvg->count() > 0){
            for ($i=0; $i < $match->teams_qty; $i++) {
                $id = $playerAvg->last()->get('id');
                $teams->get('team'.($i+1))->put( $id , $playerAvg->pop() );
                if (isset($player_id) && $id != $player_id){
                    $temp = PlayerMatch::where('match_id', $match->id)
                        ->where('player_id', $id)->first();
                    $temp->team_type = ('team'.($i+1));
                    $temp->save();
                }
            }
            if ($check == 'desc'){
                $playerAvg = $playerAvg->sortBy('avg');
                $check = 'asc';
            }else{
                $playerAvg = $playerAvg->sortByDesc('avg');
                $check = 'desc';
            }
            $j++;
        }

        if ($playerAvg->count() > 0){
            $id = $playerAvg->first()->get('id');
            $teams->get('team1')->put( $id , $playerAvg->shift() );
            if (isset($player_id) && $id != $player_id){
                $temp = PlayerMatch::where('match_id', $match->id)
                        ->where('player_id', $id)->first();
                $temp->team_type = ('team1');
                $temp->save();
            }
        }

        if (isset($player_id)){
            foreach ($teams as $team){
                if ($team->get($newPlayer->id)){
                    $new = $teams->search($team);
                }
            }
        }else{
            $new = 'none';
        }

        return response(['teams' => new TeamMakerResource($teams), 'message' => 'Teams generated successfully', 'new' => $new], 200);
    }

    public function autoTeamLineUp(Request $request)
    {
        $data = $request->all();
        $i = 0;
        // print_r($data);

        $match = Match::find($data['match']);
        // print_r($match);

        // echo $match->max_players."\n";
        // echo $match->teams_qty;

        $players = PlayerMatch::get()->where('match_id', $data['match']);

        // print_r($players);

        $playerAvg = collect([]);
        foreach ($players as $player){
            $playerinfo = Player::find($player->player_id);
            $avg = array(['name' => $playerinfo->name, 'avg' => ($playerinfo->offense + $playerinfo->defense) / 2]);
            $playerAvg->push($avg)->sortByDesc('avg');
        }

        print_r($playerAvg);

    }
}
