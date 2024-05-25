<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id',
        'player_x',
        'player_o',
        'game_state',
        'winner',
    ];
    public function moves()
    {
        return $this->hasMany(Move::class);
    }
}
