<?php

namespace App\Http\Controllers\Kaprodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\MahasiswaRepo;

class MahasiswaController extends Controller
{
    public MahasiswaRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new MahasiswaRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }

    public function getSimpan(Request $req)
    {
        $data = [
            'mahasiswa_id' => $req->input('mahasiswa_id'),
            'username' => $req->input('username'),
            'nidn' => $req->input('nidn'),
            'fakultas_id' => $req->input('fakultas_id'),
            'email' => $req->input('email'),
            'password' => $req->input('password'),
        ];

        $data = $this->skripsi->getSimpan($req);
        return $data;
    }

    public function getHapus($mahasiswaId)
    {
        $data = [
            'mahasiswa_id' => $mahasiswaId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
