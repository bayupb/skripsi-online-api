<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Dospem extends Authenticatable implements JWTSubject
{

    
    // use Authenticatable, Authorizable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dospem';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'dospem_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   protected $hidden = ['password'];

    /**
     * The function returns a relationship between the current model and the model specified in the
     * first parameter
     * 
     * @return The relationship is being returned.
     */
    public function getFakultas()
    {
        return $this->belongsTo('App\Models\Fakultas', 'fakultas_id')->select(
            'fakultas_id',
            'singkat',
            'nama_fakultas'
        );
    }

    /**
     * Return the query with the specified columns and with the specified relations.
     * 
     * @param query The query builder instance.
     * 
     * @return <code>{
     *     "data": [
     *         {
     *             "dospem_id": 1,
     *             "dospem_nama": "Dosen Pembimbing 1",
     *             "dospem_nip": "123456789",
     *             "dospem_fakultas": 1,
     */
    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->selectRaw('*, ROW_NUMBER() over(ORDER BY dospem_id DESC) no_urut')
            ->with(['getFakultas']);
    }

    
    /**
     * The getJWTIdentifier() method is used to get the primary key of the authenticated user.
     * 
     * @param value The value of the attribute.
     * 
     * @return The primary key of the user.
     */
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

    /**
     * If the value of the jenis_kelamin attribute is 0, return 'Perempuan', otherwise return 'Laki'
     * 
     * @return The value of the attribute jenis_kelamin.
     */
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
