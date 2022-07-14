<?php
namespace App\Repositories\Pengurus;

use Carbon\Carbon;
use App\Models\Dospem;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use App\Helpers\ResponseHelpers;
use App\Helpers\IndonesiaTimeHelpers;
use App\Models\MappingDospemMahasiswa;
use App\Models\NotificationDospemMahasiswa;

class MappingDosenMahasiswa
{
    public function getMahasiswaPengajuanAcc()
    {
        try {
            $data = Mahasiswa::data()
                ->whereHas('getPengajuanSkripsi', function ($query) {
                    $query->where('telah_disetujui_kaprodi', 3);
                })
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
    public function getList()
    {
        try {
            // $data = MappingDospemMahasiswa::data()->get();
            $data = Mahasiswa::data()
                ->whereHas('getPengajuanSkripsi', function ($query) {
                    $query->where('telah_disetujui_kaprodi', 3);
                })
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
            $mahasiswaId = isset($params['mahasiswa_id'])
                ? $params['mahasiswa_id']
                : '';
            if (strlen($mahasiswaId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama mahasiswa skripsi tidak boleh kosong'
                );
            }
            $dospem1 = isset($params['dospem_1_id'])
                ? $params['dospem_1_id']
                : '';
            if (strlen($dospem1) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama Dospem 1 skripsi tidak boleh kosong'
                );
            }
            $dospem2 = isset($params['dospem_2_id'])
                ? $params['dospem_2_id']
                : '';
            if (strlen($dospem2) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama Dospem 2 skripsi tidak boleh kosong'
                );
            }

            $mappingDosenMahasiswaId = isset($params['pengajuan_skripsi_id'])
                ? $params['pengajuan_skripsi_id']
                : '';

            if (strlen($mappingDosenMahasiswaId) == 0) {
                $data = new MappingDospemMahasiswa();
                $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
            } else {
                $data = MappingDospemMahasiswa::query()->find(
                    $mappingDosenMahasiswaId
                );
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

            $datas = Mahasiswa::data()
                ->where('mahasiswa_id', $mahasiswaId)
                ->whereHas('getPengajuanSkripsi', function ($query) {
                    $query->where('telah_disetujui_kaprodi', 3);
                })
                ->first();
            if (!$datas) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Data tidak ditemukan'
                );
            }

            $data->mahasiswa_id = $mahasiswaId;
            $data->dospem_1_id = $dospem1;
            $data->dospem_2_id = $dospem2;
            if ($data->save()) {
                $notification = new NotificationDospemMahasiswa();
                $notification->notification_mahasiswa_dospem_id = Str::uuid();
                $notification->mahasiswa_id = $data->mahasiswa_id;
                $notification->keterangan_dospem =
                    'Kamu mendapatkan dospem 1 :' .
                    $data->dospem_1_id .
                    ' dan ' .
                    $data->dospem_2_id;
                $notification->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                    Carbon::now()
                );
                $notification->save();
            }

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

            $data = MappingDospemMahasiswa::query()->find($pengajuanSkripsiId);
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
