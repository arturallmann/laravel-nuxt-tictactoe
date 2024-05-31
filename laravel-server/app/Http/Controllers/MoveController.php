<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Move;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    //POST(/moves)
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

        try {
            $move = new Move;
            $move->game_id = $id;
            $move->player = $validated['player'];
            $move->location = $validated['location'];
            $move->order = $validated['order'];
            $move->move_timestamp = now();
            $move->save();

            return response()->json(['message' => 'Move completed successfully', 'move' => $move], 201);
        } catch (\Exception $e) {
            Log::error('Error saving move: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while saving the move'], 500);
        }
    }

    //GET(/moves) by game ID
    public function getMovesByGame($id) {

        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        $moves = $game->moves()->orderBy('order')->get();
        return response()->json(['moves' => $moves], 201);
    }
    //DELETE(/moves/{id})
    public function deleteMove($id)
    {
        $move = Move::find($id);
        if (!$move) {
            return response()->json(['message' => 'Move not found'], 404);
        }

        try {
            $move->delete();
            return response()->json(['message' => 'Move deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting move: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the move'], 500);
        }
    }
}
