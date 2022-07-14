<?php

namespace App\Http\Controllers\Kaprodi;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\VerifikasiPengajuanSkripsiRepo;
use Illuminate\Http\Request;

class VerifikasiPengajuanSkripsiController extends Controller
{
    public VerifikasiPengajuanSkripsiRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new VerifikasiPengajuanSkripsiRepo();
    }

    public function getDataAllVerifikasiPengajuan()
    {
        $data = $this->skripsi->getDataAllVerifikasiPengajuan();
        return $data;
    }
    public function getDataDitolakVerifikasiPengajuan()
    {
        $data = $this->skripsi->getDataDitolakVerifikasiPengajuan();
        return $data;
    }
    public function getDataDirevisiPengajuan()
    {
        $data = $this->skripsi->getDataDirevisiPengajuan();
        return $data;
    }
    public function getDataDiterimaPengajuan()
    {
        $data = $this->skripsi->getDataDiterimaPengajuan();
        return $data;
    }

    public function getMelakukanVerifikasiPengajuan(
        Request $req,
        $pengajuanSkripsiId
    ) {
        $data = [
            'pengajuan_skripsi_id' => $pengajuanSkripsiId,
            'telah_disetujui_kaprodi' => $req->input('telah_disetujui_kaprodi'),
        ];
        $data = $this->skripsi->getMelakukanVerifikasiPengajuan($data);
        return $data;
    }
}
