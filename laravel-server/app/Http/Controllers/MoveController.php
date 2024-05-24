<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Move;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    //POST(games/{id}/moves)
    public function createMove(Request $request, $id) {

        $validated = $request->validate([
            'player' => 'required|string|max:255',
            'location' => 'required|integer|between:1,9',
            'order' => 'required|integer|min:1',
        ]);

        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $move = new Move;
        $move->game_id = $id;
        $move->player = $validated['player'];
        $move->location = $validated['location'];
        $move->order = $validated['order'];
        $move->move_timestamp = Carbon::now(); // Setting the current time using Carbon
        $move->save();

        return response()->json(['message' => 'Move completed successfully', 'move' => $move], 201);
    }
    //GET(games/{id}/moves)
    public function index($gameId) {
        $move = Move::all();
        return response()->json(['moves' => $move], 201);
    }
}
