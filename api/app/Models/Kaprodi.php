<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
// use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Kaprodi extends Authenticatable implements JWTSubject
{
    // use Authenticatable, Authorizable;
    protected $table = 'kaprodi';
    protected $primaryKey = 'kaprodi_id';
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query
            // ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->selectRaw(
                '*, ROW_NUMBER() over(ORDER BY kaprodi_id DESC) no_urut'
            );
    }

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
