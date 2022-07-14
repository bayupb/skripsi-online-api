<?php

namespace App\Http\Controllers\Kaprodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\DospemRepo;

class DospemController extends Controller
{
    public DospemRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new DospemRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }

    public function getSimpan(Request $req)
    {
        $data = [
            'dospem_id' => $req->input('dospem_id'),
            'username' => $req->input('username'),
            'fakultas_id' => $req->input('fakultas_id'),
            'nidn' => $req->input('nidn'),
            'email' => $req->input('email'),
            'password' => $req->input('password'),
        ];

        $data = $this->skripsi->getSimpan($req);
        return $data;
    }

    public function getHapus($dospemId)
    {
        $data = [
            'dospem_id' => $dospemId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
