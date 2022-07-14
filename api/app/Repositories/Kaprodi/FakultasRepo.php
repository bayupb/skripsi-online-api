<?php

namespace App\Repositories\Kaprodi;

use Carbon\Carbon;
use App\Models\Fakultas;
use App\Helpers\ResponseHelpers;
use App\Helpers\IndonesiaTimeHelpers;

class FakultasRepo
{
    public function getList()
    {
        try {
            $data = Fakultas::query()
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
            $singkatFakultas = isset($params['singkat'])
                ? $params['singkat']
                : '';
            if (strlen($singkatFakultas) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Singkatan Fakultas tidak boleh kosong'
                );
            }

            $namaFakultas = isset($params['nama_fakultas'])
                ? $params['nama_fakultas']
                : '';
            if (strlen($namaFakultas) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama Fakultas tidak boleh kosong'
                );
            }

            $fakultasId = isset($params['fakultas_id'])
                ? $params['fakultas_id']
                : '';

            if (strlen($fakultasId) == 0) {
                $data = new Fakultas();
                $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
            } else {
                $data = Fakultas::query()->find($fakultasId);
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

            $data->singkat = $singkatFakultas;
            $data->nama_fakultas = $namaFakultas;
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
            $fakultasId = isset($params['fakultas_id'])
                ? $params['fakultas_id']
                : '';

            if (strlen($fakultasId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Fakultas tidak boleh kosong'
                );
            }

            $data = Fakultas::query()->find($fakultasId);
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
                'Sukses menghapus data ',
                $data->nama_fakultas
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
}
