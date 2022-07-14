<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPengajuanAcc extends Model
{
    protected $table = 'notification_pengajuan_acc';
    public $incrementing = false;
    public $timestamps = false;

    public function scopeData($query)
    {
        return $query->selectRaw(
            '*, ROW_NUMBER() over(ORDER BY notification_pengajuan_acc_id DESC) no_urut'
        );
    }
}
