<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mahasiswa\PengajuanSkripsiRepo;

class PengajuanSkripsiController extends Controller
{
    public PengajuanSkripsiRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new PengajuanSkripsiRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }

    public function getSimpan(Request $req)
    {
        $data = [
            'pengajuan_skripsi_id' => $req->input('pengajuan_skripsi_id'),
            'nama_pengajuan_skripsi' => $req->input('nama_pengajuan_skripsi'),
            'deskripsi_pengajuan_skripsi' => $req->input(
                'deskripsi_pengajuan_skripsi'
            ),
        ];

        $data = $this->skripsi->getSimpan($data);
        return $data;
    }

    public function getHapus($pengajuanSkripsiId)
    {
        $data = [
            'pengajuan_skripsi_id' => $pengajuanSkripsiId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
