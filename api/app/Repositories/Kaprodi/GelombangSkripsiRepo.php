<?php

namespace App\Repositories\Kaprodi;

use Carbon\Carbon;
use App\Models\Fakultas;
use App\Helpers\ResponseHelpers;
use App\Models\GelombangSkripsi;
use App\Helpers\IndonesiaTimeHelpers;

class GelombangSkripsiRepo
{
    public function getList()
    {
        try {
            $data = GelombangSkripsi::query()
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
            $gelombangSkripsi = isset($params['gelombang'])
                ? $params['gelombang']
                : '';
            if (strlen($gelombangSkripsi) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Gelombang Skripsi tidak boleh kosong'
                );
            }
            $dateMulai = isset($params['date_mulai'])
                ? $params['date_mulai']
                : '';
            if (strlen($dateMulai) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Tanggal Mulai Gelombang tidak boleh kosong'
                );
            }
            $dateSelesai = isset($params['date_selesai'])
                ? $params['date_selesai']
                : '';
            if (strlen($dateSelesai) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Tanggal Selesai Gelombang tidak boleh kosong'
                );
            }
            $gelombangStatus = isset($params['gelombang_status'])
                ? $params['gelombang_status']
                : '';
            if (strlen($gelombangStatus) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Status Gelombang tidak boleh kosong'
                );
            }

            $gelombangSkripsiId = isset($params['gelombang_skripsi_id'])
                ? $params['gelombang_skripsi_id']
                : '';

            if (strlen($gelombangSkripsiId) == 0) {
                $data = new GelombangSkripsi();
                $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
            } else {
                $data = GelombangSkripsi::query()->find($gelombangSkripsiId);
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

            $data->gelombang = $gelombangSkripsi;
            $data->date_mulai = $dateMulai;
            $data->date_selesai = $dateSelesai;
            $data->gelombang_status = $gelombangStatus;
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
            $gelombangSkripsiId = isset($params['gelombang_skripsi_id'])
                ? $params['gelombang_skripsi_id']
                : '';

            if (strlen($gelombangSkripsiId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Gelombang Skripsi tidak boleh kosong'
                );
            }

            $data = Fakultas::query()->find($gelombangSkripsiId);
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

            $data->dihapus_pada = IndonesiaTimeHelpers::IndonesiaDate(
                Carbon::now()
            );
            $data->save();
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses menghapus data : ' . $data->gelombang,
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
}
