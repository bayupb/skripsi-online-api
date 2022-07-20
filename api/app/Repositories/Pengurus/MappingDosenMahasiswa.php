<?php
namespace App\Repositories\Pengurus;

use Carbon\Carbon;
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
            // $mappingDosenMahasiswa = MappingDospemMahasiswa::query()->whereDate(
            //     'dibuat_pada',
            //     '<',
            //     Carbon::now()->addDays(7)
            // );

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
            $dosenPembimbing = isset($params['dospem_id'])
                ? $params['dospem_id']
                : '';
            if (strlen($dosenPembimbing) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nama Dosen Pembimbing tidak boleh kosong'
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
            $data->mahasiswa_id = $mahasiswaId;
            $data->dospem_id = $dosenPembimbing;
            if ($data->save()) {
                $notification = new NotificationDospemMahasiswa();
                $notification->notification_mahasiswa_dospem_id = Str::uuid();
                $notification->mahasiswa_id = $data->mahasiswa_id;
                $notification->keterangan_dospem =
                    'Kamu telah mendapatkan dosen pembimbing';
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
