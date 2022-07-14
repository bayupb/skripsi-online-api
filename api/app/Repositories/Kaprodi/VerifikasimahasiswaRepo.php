<?php

namespace App\Repositories\Kaprodi;

use Carbon\Carbon;
use App\Models\Fakultas;
use App\Models\Mahasiswa;
use App\Helpers\ResponseHelpers;
use App\Helpers\IndonesiaTimeHelpers;

class VerifikasimahasiswaRepo
{
    // mengambil Mahasiswa yang belum di verifikasi aktif oleh kaprodi
    public function getDataNonVerifikasiMahasiswa()
    {
        try {
            $data = Mahasiswa::where('aktif_mahasiswa', '=', 0)
                ->data()
                ->get();
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses mengambil data',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
    // mengambil Mahasiswa yang sudah di verifikasi aktif oleh kaprodi
    public function getDataVerifikasiMahasiswa()
    {
        try {
            $data = Mahasiswa::where('aktif_mahasiswa', '=', 1)
                ->data()
                ->get();
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses mengambil data',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }

    // melakukan verifikasi data akun mahasiswa untuk aktif

    public function getMelakukanVerifikasiMahasiswa($params)
    {
        try {
            $mahasiswaId = isset($params['mahasiswa_id'])
                ? $params['mahasiswa_id']
                : '';
            if (strlen($mahasiswaId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Mahasiswa Id tidak boleh kosong!'
                );
            }

            $data = Mahasiswa::query()->find($mahasiswaId);
            if (is_null($data)) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Mahasiswa tersebut tidak ditemukan!'
                );
            }
            $data->diubah_pada = IndonesiaTimeHelpers::IndonesiaDate(
                Carbon::now()
            );
            $data->aktif_mahasiswa = 1;
            $data->save();

            return ResponseHelpers::ResponseSucces(
                200,
                'Akun dengan nama :' . $data->username . ' telah diverifikasi',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
}
