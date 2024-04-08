<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerMatch extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = ['player_id','match_id'];

    protected $fillable = [
        'player_id',
        'match_id',
        'team_type',
        'goals',
        'assists',
        'perf_o',
        'perf_d'
    ];

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

/**
     * Set the keys for a Delete update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForDeleteQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForDeleteQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForDeleteQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a Delete query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForDeleteQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function match(){
        return $this->belongsTo(Match::class, 'match_id', 'id');
    }
}
