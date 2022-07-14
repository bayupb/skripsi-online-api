<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationDospemMahasiswa extends Model
{
    protected $table = 'notification_mahasiswa_dospem';
    public $incrementing = false;
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query->selectRaw(
            '*, ROW_NUMBER() over(ORDER BY notification_mahasiswa_dospem_id DESC) no_urut'
        );
    }
}
