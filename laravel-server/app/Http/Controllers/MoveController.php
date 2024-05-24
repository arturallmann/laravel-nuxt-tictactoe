<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Move;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    //POST(/move)
    public function createMove(Request $request) {

        $validated = $request->validate([
            'game_id' => 'required|int',
            'player' => 'required|string|max:255',
            'location' => 'required|integer|between:1,9',
            'order' => 'required|integer|min:1',
        ]);

        $move = new Move;
        $move->game_id = $validated['game_id'];
        $move->player = $validated['player'];
        $move->location = $validated['location'];
        $move->order = $validated['order'];
        $move->move_timestamp = Carbon::now(); // Setting the current time using Carbon
        $move->save();


        return response()->json(['message' => 'Move completed successfully', 'move' => $move], 201);
    }
    //GET(/move)
    public function index() {
        $move = Move::all();
        return response()->json(['moves' => $move], 201);
    }
    //DELETE(/move/{id})
    public function destroy($id)
    {
        $move = Move::findOrFail($id);

        $move->delete();

        return response()->json(['message'=>'Move deleted successfully'], 201);
    }
}
