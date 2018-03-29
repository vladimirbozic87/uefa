<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'owner',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Relation with players
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function player()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * Relation with active players
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activePlayers()
    {
        return $this->hasMany('App\Player')->where('active', 1);
    }
}
