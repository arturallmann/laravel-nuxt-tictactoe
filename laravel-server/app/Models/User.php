<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'game_id',
        'username',
        'password'
    ];
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
