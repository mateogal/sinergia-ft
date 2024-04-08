<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'lastname',
        'alias',
        'offense',
        'defense',
        'type',
        'photo',
    ];

    protected $casts = [
        'offense' => 'integer',
        'defense' => 'integer',
    ];

    public function matches()
    {
        // return $this->belongsToMany(Match::class, 'player_match')->withPivot('goals')->using(PlayerMatch::class);
        return $this->hasMany(PlayerMatch::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
