<?php
namespace App\Repositories\Mahasiswa;

use Carbon\Carbon;
use App\Helpers\ResponseHelpers;
use App\Helpers\IndonesiaTimeHelpers;
use App\Models\PengajuanSkripsi;

class PengajuanSkripsiRepo
{
    public function getList()
    {
        try {
            $data = PengajuanSkripsi::query()
                ->where(
                    'mahasiswa_id',
                    auth()
                        ->guard('api_mahasiswa')
                        ->user()->mahasiswa_id
                )
                ->data()
                ->get();
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses mengambil data',
                $data
            );
        } catch (\Throwable $th) {
            ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }

    public function getSimpan($params)
    {
        try {
            $namaPengajuanSkripsi = isset($params['nama_pengajuan_skripsi'])
                ? $params['nama_pengajuan_skripsi']
                : '';
            if (strlen($namaPengajuanSkripsi) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama pengajuan skripsi tidak boleh kosong'
                );
            }
            $deskripsiPengajuanSkripsi = isset(
                $params['deskripsi_pengajuan_skripsi']
            )
                ? $params['deskripsi_pengajuan_skripsi']
                : '';
            if (strlen($deskripsiPengajuanSkripsi) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama pengajuan skripsi tidak boleh kosong'
                );
            }

            $pengajuanSkripsiId = isset($params['pengajuan_skripsi_id'])
                ? $params['pengajuan_skripsi_id']
                : '';

            if (strlen($pengajuanSkripsiId) == 0) {
                $data = new PengajuanSkripsi();
                $data->mahasiswa_id = auth()
                    ->guard('api_mahasiswa')
                    ->user()->mahasiswa_id;
                $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
            } else {
                $data = PengajuanSkripsi::query()->find($pengajuanSkripsiId);
                if (is_null($data)) {
                    return ResponseHelpers::ResponseError(
                        404,
                        'Data tidak ditemukan'
                    );
                }

                if (!is_null($data->dihapus_pada)) {
                    return ResponseHelpers::ResponseError(
                        404,
                        'Data sudah dihapus'
                    );
                }
                $data->diubah_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
            }

            $data->nama_pengajuan_skripsi = $namaPengajuanSkripsi;
            $data->deskripsi_pengajuan_skripsi = $deskripsiPengajuanSkripsi;
            $data->telah_disetujui_kaprodi = 0;
            $data->save();

            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses menyimpan data',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }

    public function getHapus($params)
    {
        try {
            $pengajuanSkripsiId = isset($params['pengajuan_skripsi_id'])
                ? $params['pengajuan_skripsi_id']
                : '';

            if (strlen($pengajuanSkripsiId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Fakultas tidak boleh kosong'
                );
            }

            $data = PengajuanSkripsi::query()->find($pengajuanSkripsiId);
            if (is_null($data)) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Data tidak ditemukan'
                );
            }
            if ($data->telah_disetujui_kaprodi == 3) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Pengajuan ide anda sudah di setujui, tidak bisa dihapus!'
                );
            }

            if (!is_null($data->dihapus_pada)) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Data sudah dihapus'
                );
            }

            $data->dihapus_pada = IndonesiaTimeHelpers::IndonesiaDate(
                Carbon::now()
            );
            $data->save();
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses menghapus data ',
                $data->nama_pengajuan_skripsi
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
}
