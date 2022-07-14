<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Pengurus extends Authenticatable implements JWTSubject
{
    // use Authenticatable, Authorizable;
    protected $table = 'pengurus';
    protected $primaryKey = 'pengurus_id';
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->selectRaw(
                '*, ROW_NUMBER() over(ORDER BY pengurus_id DESC) no_urut'
            )
            ->with(['getFakultas']);
    }
    protected $hidden = ['password'];
    public function getUsernameAttribute($value)
    {
        return ucfirst($value);
    }

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

    protected function getJenisKelaminAttribute()
    {
        if ($this->attributes['jenis_kelamin'] == 0) {
            return 'Perempuan';
        } else {
            return 'Laki';
        }

        return $this->jenis_kelamin;
    }
}
