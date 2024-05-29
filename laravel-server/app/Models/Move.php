<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'games_id',
        'player',
        'location',
        'order',
        'time_stamp',
    ];
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
