<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all();
        return response([ 'players' => PlayerResource::collection($players), 'message' => 'Retrieved successfully'], 200);
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
            'id' => 'required',
            'name' => 'required|max:30',
            'lastname' => 'required|max:50',
            'alias' => 'required|max:20',
            'offense' => 'required|integer|between:1,10',
            'defense' => 'required|integer|between:1,10',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => 'Invalid data', 'Validation Error'], 400);
        }

        $data['photo'] = '-';
        $player = Player::create($data);

        return response(['project' => new PlayerResource($player), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        print_r($player);
        return response(['player' => new PlayerResource($player), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        $player->update($request->all());

        return response(['player' => new PlayerResource($player), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        $player->delete();

        return response(['message' => 'Deleted']);
    }

    public function getMatches($id)
    {
        $matches = Player::find($id)->matches;
        return response([ 'matches' => PlayerResource::collection($matches), 'message' => 'Retrieved successfully'], 200);

    }
}
