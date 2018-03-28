<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id', 'team_id', 'position_id', 'no_of_players',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function position()
    {
        return $this->belongsTo('App\Position', 'position_id');
    }

    public function players()
    {
        return $this->hasMany('App\Player', 'position_id', 'position_id')
            ->where('active', 1);
    }

}
