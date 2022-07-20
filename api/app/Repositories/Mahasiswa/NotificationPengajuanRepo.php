<?php
namespace App\Repositories\Mahasiswa;

use Carbon\Carbon;
use App\Helpers\ResponseHelpers;
use App\Models\NotificationPengajuanAcc;

class NotificationPengajuanRepo
{
    public function getList()
    {
        try {
            $date = Carbon::now()->addDays(7);
            $data = NotificationPengajuanAcc::query()
                ->where(
                    'mahasiswa_id',
                    auth()
                        ->guard('api_mahasiswa')
                        ->user()->mahasiswa_id
                )
                ->whereDate('dibuat_pada', '<', $date)
                ->data()
                ->get();

            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses mengambil data',
                $data
            );
            return ResponseHelpers::ResponseError(404, 'Tidak ada data');
        } catch (\Throwable $th) {
            ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }
}
