<?php

namespace App\Repositories\Dospem;

use Carbon\Carbon;
use App\Models\Bimbingan;
use App\Helpers\ResponseHelpers;
use App\Models\GelombangSkripsi;
use App\Helpers\IndonesiaTimeHelpers;

class BimbinganRepo
{
    public function getList()
    {
        try {
            $data = Bimbingan::query()
                ->data()
                ->get();
            // dd($data);
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses mengambil data',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }

    public function getSimpan($params)
    {
        try {
            $namaBimbingan = isset($params['nama_bimbingan'])
                ? $params['nama_bimbingan']
                : '';

            if (strlen($namaBimbingan) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama bimbingan tidak boleh kosong'
                );
            }

            $tempatBimbingan = isset($params['tempat_bimbingan'])
                ? $params['tempat_bimbingan']
                : '';

            if (strlen($tempatBimbingan) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Tempat bimbingan tidak boleh kosong'
                );
            }
            $tanggalBimbingan = isset($params['tanggal_bimbingan'])
                ? $params['tanggal_bimbingan']
                : '';

            if (strlen($tanggalBimbingan) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Tanggal bimbingan tidak boleh kosong'
                );
            }
            $jamBimbingan = isset($params['jam_bimbingan'])
                ? $params['jam_bimbingan']
                : '';

            if (strlen($jamBimbingan) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Jam bimbingan tidak boleh kosong'
                );
            }

            $bimbinganId = isset($params['bimbingan_id'])
                ? $params['bimbingan_id']
                : '';
            if (strlen($bimbinganId) == 0) {
                $data = new Bimbingan();
                $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
                $data->dospem_id = auth()
                    ->guard('api_dospem')
                    ->user()->dospem_id;
            } else {
                $data = Bimbingan::find($bimbinganId);
                $data->dospem_id = auth()
                    ->guard('api_dospem')
                    ->user()->dospem_id;
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
            $data->nama_bimbingan = $namaBimbingan;
            $data->tempat_bimbingan = $tempatBimbingan;
            $data->tanggal_bimbingan = $tanggalBimbingan;
            $data->jam_bimbingan = $jamBimbingan;
            $data->save();

            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses menyimpan data',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }

    public function getHapus($params)
    {
        try {
            $bimbinganId = isset($params['bimbingan_id'])
                ? $params['bimbingan_id']
                : '';
            if (strlen($bimbinganId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Bimbingan Id tidak ditemukan'
                );
            }

            $data = Bimbingan::query()->find($bimbinganId);
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
                'Berhasil mengahpus data ' . $data->nama_bimbingan,
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }
}
