<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Institution extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'short_name', 'note'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function persons()
    {
        return $this->hasMany(Person::class, 'institution');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'institution');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'institution');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address');
    }
}