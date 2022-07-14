<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Dospem extends Authenticatable implements JWTSubject
{
    // use Authenticatable, Authorizable;
    protected $table = 'dospem';
    protected $primaryKey = 'dospem_id';
    public $timestamps = false;

    public function getFakultas()
    {
        return $this->belongsTo('App\Models\Fakultas', 'fakultas_id')->select(
            'fakultas_id',
            'singkat',
            'nama_fakultas'
        );
    }

    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->selectRaw('*, ROW_NUMBER() over(ORDER BY dospem_id DESC) no_urut')
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
