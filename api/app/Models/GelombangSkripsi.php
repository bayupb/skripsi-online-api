<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GelombangSkripsi extends Model
{
    protected $table = 'gelombang_skripsi';
    protected $primaryKey = 'gelombang_skripsi_id';
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))

            ->selectRaw(
                '*, ROW_NUMBER() over(ORDER BY gelombang_skripsi_id DESC) no_urut'
            );
    }

    protected function getGelombangStatusAttribute()
    {
        if ($this->attributes['gelombang_status'] == 0) {
            return 'Belum Aktif';
        } else {
            return 'Telah Aktif';
        }

        return $this->gelombang_status;
    }
}
