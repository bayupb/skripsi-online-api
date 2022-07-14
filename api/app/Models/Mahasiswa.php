<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Mahasiswa extends Authenticatable implements JWTSubject
{
    // use Authenticatable, Authorizable;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'mahasiswa_id';
    public $timestamps = false;

    protected $hidden = ['password'];

    public function getFakultas()
    {
        return $this->belongsTo('App\Models\Fakultas', 'fakultas_id')->select(
            'fakultas_id',
            'singkat',
            'nama_fakultas'
        );
    }

    public function getPengajuanSkripsi()
    {
        return $this->hasMany(
            'App\Models\PengajuanSkripsi',
            'mahasiswa_id',
            'mahasiswa_id'
        )->select(
            'pengajuan_skripsi_id',
            'nama_pengajuan_skripsi',
            'deskripsi_pengajuan_skripsi',
            'mahasiswa_id',
            'telah_disetujui_kaprodi'
        );
    }
    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->selectRaw(
                '*, ROW_NUMBER() over(ORDER BY mahasiswa_id DESC) no_urut'
            )
            ->with(['getFakultas', 'getPengajuanSkripsi']);
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
    public function getUsernameAttribute($value)
    {
        return ucfirst($value);
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
