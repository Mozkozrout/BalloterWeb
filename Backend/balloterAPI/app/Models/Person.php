<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Person extends Model implements AuthenticatableContract, AuthorizableContract
{

    protected $table="persons";

    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'birthdate', 'id_number', 'address', 'note', 'institution'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function ballots()
    {
        return $this->belongsToMany(Ballot::class, 'ballot_person', 'person_id', 'ballot_id')
                   ->withPivot('id', 'role', 'comment', 'cont_points', 'str_points', 'style_points', 'cq_points', 'best_speaker')
                   ->as('debate')->withTimestamps();
    }

    public function user()
    {
        return $this->HasOne(User::class, 'person');
    }

    public function team()
    {
        return $this->belongsToMany(Team::class, 'person_team', 'person_id', 'team_id');
    }

    public function motions()
    {
        return $this->hasMany(Motion::class, 'added_by', 'id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address');
    }
}
