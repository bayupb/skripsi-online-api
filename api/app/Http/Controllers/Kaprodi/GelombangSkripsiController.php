<?php

namespace App\Http\Controllers\Kaprodi;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\GelombangSkripsiRepo;
use Illuminate\Http\Request;

class GelombangSkripsiController extends Controller
{
    public GelombangSkripsiRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new GelombangSkripsiRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }

    public function getSimpan(Request $req)
    {
        $data = [
            'gelombang_skripsi_id' => $req->input('gelombang_skripsi_id'),
            'gelombang' => $req->input('gelombang'),
            'date_mulai' => $req->input('date_mulai'),
            'date_selesai' => $req->input('date_selesai'),
            'gelombang_status' => $req->input('gelombang_status'),
        ];

        $data = $this->skripsi->getSimpan($data);
        return $data;
    }

    public function getHapus($gelombangSkripsiId)
    {
        $data = [
            'gelombang_skripsi_id' => $gelombangSkripsiId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
