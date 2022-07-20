<?php

namespace App\Repositories\Kaprodi;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\ResponseHelpers;
use App\Models\PengajuanSkripsi;
use App\Helpers\IndonesiaTimeHelpers;
use App\Models\NotificationPengajuanAcc;

class VerifikasiPengajuanSkripsiRepo
{
    // 0 = Belum dibaca
    // 1 = Di tolak
    // 2 = Di Revisi
    // 3 = Di acc lanjut skripsi

    // mengambil skripsi yang belum di verifikasi aktif oleh kaprodi
    public function getDataAllVerifikasiPengajuan()
    {
        try {
            $count = PengajuanSkripsi::where(
                'telah_disetujui_kaprodi',
                '=',
                0
            )->count();
            $data = PengajuanSkripsi::where('telah_disetujui_kaprodi', '=', 0)
                ->data()
                ->get();
            return ResponseHelpers::ResponseCount(
                200,
                'Sukses mengambil data',
                $count,
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
    public function getDataDitolakVerifikasiPengajuan()
    {
        try {
            $count = PengajuanSkripsi::where(
                'telah_disetujui_kaprodi',
                '=',
                1
            )->count();
            $data = PengajuanSkripsi::where('telah_disetujui_kaprodi', '=', 1)
                ->data()
                ->get();
            return ResponseHelpers::ResponseCount(
                200,
                'Sukses mengambil data',
                $count,
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
    // mengambil pengajuan skripsi yang direvisi oleh kaprodi
    public function getDataDirevisiPengajuan()
    {
        try {
            $count = PengajuanSkripsi::where(
                'telah_disetujui_kaprodi',
                '=',
                2
            )->count();
            $data = PengajuanSkripsi::where('telah_disetujui_kaprodi', '=', 2)
                ->data()
                ->get();
            return ResponseHelpers::ResponseCount(
                200,
                'Sukses mengambil data',
                $count,
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
    public function getDataDiterimaPengajuan()
    {
        try {
            $count = PengajuanSkripsi::where(
                'telah_disetujui_kaprodi',
                '=',
                3
            )->count();
            $data = PengajuanSkripsi::where('telah_disetujui_kaprodi', '=', 3)
                ->data()
                ->get();
            return ResponseHelpers::ResponseCount(
                200,
                'Sukses mengambil data',
                $count,
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }

    // melakukan verifikasi data pengajuan yang dterima / tidak

    public function getMelakukanVerifikasiPengajuan($params)
    {
        try {
            $pengajuanSkripsiId = isset($params['pengajuan_skripsi_id'])
                ? $params['pengajuan_skripsi_id']
                : '';
            if (strlen($pengajuanSkripsiId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Pengajuan Id tidak boleh kosong!'
                );
            }

            $telahDisetujui = isset($params['telah_disetujui_kaprodi'])
                ? $params['telah_disetujui_kaprodi']
                : '';
            if (strlen($telahDisetujui) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Status pengajuan harus diisikan!'
                );
            }

            $data = PengajuanSkripsi::query()->find($pengajuanSkripsiId);
            if (is_null($data)) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Pengajuan tersebut tidak ditemukan!'
                );
            }
            $data->diubah_pada = IndonesiaTimeHelpers::IndonesiaDate(
                Carbon::now()
            );
            $data->telah_disetujui_kaprodi = $telahDisetujui;
            if ($data->save()) {
                $notification = new NotificationPengajuanAcc();
                $notification->notification_pengajuan_acc_id = Str::uuid();
                $notification->mahasiswa_id = $data->mahasiswa_id;
                $notification->pengajuan_skripsi_id = $pengajuanSkripsiId;
                $notification->nama_pengajuan = $data->nama_pengajuan_skripsi;
                $notification->deskripsi_notification =
                    'Pengajuan skripsi dengan judul ' .
                    $data->nama_pengajuan_skripsi .
                    ' di ' .
                    $data->telah_disetujui_kaprodi;
                $notification->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
                $notification->save();
            }

            if ($data->telah_disetujui_kaprodi) {
                return ResponseHelpers::ResponseSucces(
                    200,
                    'Pengajuan Skripsi dengan judul : ' .
                        $data->nama_pengajuan_skripsi .
                        ' di ' .
                        $data->telah_disetujui_kaprodi,
                    $data
                );
            }
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
}
