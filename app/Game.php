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
        'team_one_id', 'team_two_id', 'ready_to_play', 'score',
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
     * Relation with team one
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamOne()
    {
        return $this->belongsTo('App\Team', 'team_one_id');
    }

    /**
     * Relation with team two
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamTwo()
    {
        return $this->belongsTo('App\Team', 'team_two_id');
    }

}