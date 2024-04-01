<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Support\Facades\Hash;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username', 'password', 'preferred_locale', 'api_token', 'admin', 'person',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'admin',
    ];

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    public function setRole() {
        $this->role = 'none';
        if ($this->isAdmin()) $this->role = 'admin';
        return $this->role;
    }

    /**
     * Sets Api Token parameter and saves to the DB
     */
    public function setApiToken()
    {
        $this->api_token = sha1($this->id.time());
        $this->save();
    }

    /**
     * Converts username to lowercase
     * @param string $username
     * @return string
     */
    static public function normalizeUserName(string $username): string
    {
        return strtolower($username);
    }

    /**
     * Check password
     * @param $password
     * @return bool
     */
    public function isPasswordCorrect($password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person');
    }

    public function setPerson($person_id)
    {
        $this->person = $person_id;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role');
    }
}
