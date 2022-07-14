<?php

namespace App\Repositories\Kaprodi;

use Carbon\Carbon;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Hash;
use App\Helpers\IndonesiaTimeHelpers;
use App\Models\Mahasiswa;

class MahasiswaRepo
{
    public function getList()
    {
        try {
            $data = Mahasiswa::query()
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
            $username = isset($params['username']) ? $params['username'] : '';
            if (strlen($username) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Username tidak boleh kosong'
                );
            }

            $email = isset($params['email']) ? $params['email'] : '';
            if (strlen($email) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Email tidak boleh kosong'
                );
            }
            $password = isset($params['password']) ? $params['password'] : '';
            if (strlen($password) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Password tidak boleh kosong'
                );
            }
            $jenisKelamin = isset($params['jenis_kelamin'])
                ? $params['jenis_kelamin']
                : '';
            if (strlen($jenisKelamin) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Jenis Kelamin tidak boleh kosong'
                );
            }
            $nimn = isset($params['nimn']) ? $params['nimn'] : '';
            if (strlen($nimn) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nimn Mahasiswa tidak boleh kosong'
                );
            }

            if ($nimn < 12) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nimn Mahasiswa tidak boleh lebih dari 12 angka'
                );
            }
            $fakultasId = isset($params['fakultas_id'])
                ? $params['fakultas_id']
                : '';
            if (strlen($fakultasId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nidn Guru tidak boleh kosong'
                );
            }
            $mahasiswaId = isset($params['mahasiswa_id'])
                ? $params['mahasiswa_id']
                : '';

            if (strlen($mahasiswaId) == 0) {
                $data = new Mahasiswa();

                $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
            } else {
                $data = Mahasiswa::query()->find($mahasiswaId);
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

            $data->nimn = $nimn;
            $data->username = $username;
            $data->fakultas_id = $fakultasId;
            $data->jenis_kelamin = $jenisKelamin;
            $data->email = $email;
            $data->password = Hash::make($password);

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
            $mahasiswaId = isset($params['mahasiswa_id'])
                ? $params['mahasiswa_id']
                : '';

            if (strlen($mahasiswaId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Mahasiswa tidak boleh kosong'
                );
            }

            $data = Mahasiswa::query()->find($mahasiswaId);
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
                $data->username
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(404, $th->getMessage());
        }
    }
}
