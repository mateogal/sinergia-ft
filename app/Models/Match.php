<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'res_t1',
        'res_t2',
        'max_players',
        'teams_qty',
        'field_id',
        'finished'
    ];

    protected $casts = [
        'res_t1' => 'integer',
        'res_t2' => 'integer',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function player_match()
    {
        return $this->hasMany(PlayerMatch::class);
    }
}
