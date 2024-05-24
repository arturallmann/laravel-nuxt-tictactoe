<?php

namespace App\Http\Controllers;

use App\Models\Games;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function store(Request $request) {

        $data = $request->validate([
            'player_x' => 'required|string|max:50',
            'player_o' => 'required|string|max:50',
            'in_progress' => 'required|boolean',
            'winner' => 'nullable|string|max:50',
            'created_at' => 'required|timestamp'
        ]);
        $game = new Games($data);
        $game->save();

        return response()->json(['message' => 'Game added successfully'], 201);

    }

}
