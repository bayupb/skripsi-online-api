<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $table = 'bimbingan';
    protected $primaryKey = 'bimbingan_id';
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query
            ->whereNull($query->qualifyColumn('dihapus_pada'))
            ->selectRaw(
                '*, ROW_NUMBER() over(ORDER BY bimbingan_id DESC) no_urut'
            );
    }
}
