<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Event extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'beginning', 'end', 'institution', 'note'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'event_team', 'event_id', 'team_id'); 
    }

    public function institution()
    {
        return $this->belongsTo(institution::class, 'institution');
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class, 'tournament');
    }

}