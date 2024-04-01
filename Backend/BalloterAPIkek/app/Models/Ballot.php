<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Ballot extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tournament', 'date', 'adjudicator', 'motion', 'team_AFF', 'team_NEG',
        'decision', 'adj_winning_team', 'winning_team', 'adjucations', 'best_speaker',
        'pivot'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'persons'
    ];

    public function persons()
    {
        return $this->belongsToMany(Person::class, 'ballot_person', 'ballot_id', 'person_id')
                    ->withPivot('id', 'role', 'comment', 'cont_points', 'str_points', 'style_points', 'cq_points', 'best_speaker', 'author')
                    ->as('debate')->withTimestamps();
    }

    public function teamNeg()
    {
        return $this->hasOne(Team::class, 'team_NEG');
    }

    public function teamAff()
    {
        return $this->hasOne(Team::class, 'team_AFF');
    }

    public function A1()
    {
        return $this->hasOne(Person::class, 'A1');
    }

    public function A2()
    {
        return $this->hasOne(Person::class, 'A2');
    }

    public function A3()
    {
        return $this->hasOne(Person::class, 'A3');
    }

    public function N1()
    {
        return $this->hasOne(Person::class, 'N1');
    }

    public function N2()
    {
        return $this->hasOne(Person::class, 'N2');
    }

    public function N3()
    {
        return $this->hasOne(Person::class, 'N3');
    }

    public function winning_team()
    {
        return $this->hasOne(Team::class, 'winning_team');
    }

    public function adj_winning_team()
    {
        return $this->hasOne(Team::class, 'adj_winning_team');
    }

    public function best_speaker()
    {
        return $this->hasOne(Person::class, 'best_speaker');
    }

    public function motion()
    {
        return $this->belongsTo(Motion::class, 'motion');
    }

    public function tournament()
    {
        return $this->belongsTo(Event::class, 'tournament');
    }

    private function sortPersons(): array
    {
        $observer = null;

        foreach($this->persons as $person)
        {
            switch($person->debate->role)
            {
                case "Adjudicator": $adjudicator = $person;
                    break;
                case "Observer": $observer = $person;
                    break;
                case "A1": $A1 = $person;
                    break;
                case "A2": $A2 = $person;
                    break;
                case "A3": $A3 = $person;
                    break;
                case "N1": $N1 = $person;
                    break;
                case "N2": $N2 = $person;
                    break;
                case "N3": $N3 = $person;
                    break;
            }
        }
        return [$adjudicator, $observer, $A1, $A2, $A3, $N1, $N2, $N3];
    }

    /*
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function($model){
            //$model->persons = $model->persons;
            $data = $model->sortPersons();
            $model->adjudicator = $data[0];
            $model->observer = $data[1];
            $model->A1 = $data[2];
            $model->A2 = $data[3];
            $model->A3 = $data[4];
            $model->N1 = $data[5];
            $model->N2 = $data[6];
            $model->N3 = $data[7];
        });
    }
    */
}
