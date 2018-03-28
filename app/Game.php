<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_one_id', 'team_two_id', 'team_winner_id', 'ready_to_play', 'score',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function teamOne()
    {
        return $this->belongsTo('App\Team', 'team_one_id');
    }

    public function teamTwo()
    {
        return $this->belongsTo('App\Team', 'team_two_id');
    }

    public function teamWinner()
    {
        return $this->belongsTo('App\Team', 'team_winner_id');
    }

    public function formation()
    {
        return $this->hasMany('App\Formation', 'game_id');
    }

}