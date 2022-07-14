<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingDospemMahasiswa extends Model
{
    protected $table = 'mapping_mahasiswa_dospem';
    protected $primaryKey = 'mapping_mahasiswa_dospem_id';
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->with(['getDospem'])
            ->selectRaw(
                '*, ROW_NUMBER() over(ORDER BY mapping_mahasiswa_dospem_id DESC) no_urut'
            );
    }

    public function getDospem()
    {
        return $this->hasMany(
            'App\Models\Dospem',
            'dospem_id',
            'dospem_id'
        )->select('dospem_id', 'username', 'nidn', 'email');
    }
}
