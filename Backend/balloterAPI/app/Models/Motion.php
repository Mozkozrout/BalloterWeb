<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Motion extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public $test;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'added_by', 'edited_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'person'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'added_by', 'id');
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class, 'motion', 'id');
    }
}
