<?php

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // <-- import JWTSubject
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- import Auth Laravel

class Kaprodi extends Authenticatable implements JWTSubject // <-- tambahkan "Authenticatable" dan "JWTSubject
{
    use HasFactory;

    protected $table = 'kaprodi';
    protected $primaryKey = 'kaprodi_id';
    public $timestamps = false;

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
