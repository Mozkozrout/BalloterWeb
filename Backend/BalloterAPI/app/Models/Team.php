<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Team extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'registered_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function teamMembers()
    {
        return $this->belongsToMany(Person::class, 'person_team', 'team_id', 'person_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_team', 'team_id', 'event_id');
    }

    public function ballots_AFF()
    {
        return $this->belongsToMany(Ballot::class, 'team_AFF');
    }

    public function ballots_NEG()
    {
        return $this->belongsToMany(Ballot::class, 'team_NEG');
    }

    public function ballots()
    {
        return $this->array_merge($this->ballots_AFF, $this->ballots_NEG);
    }
}
