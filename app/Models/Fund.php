<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'type',
        'balance',
        'amount',
        'description'
    ];

    protected $casts = [
        'balance' => 'integer',
        'amount' => 'integer',
    ];

}
