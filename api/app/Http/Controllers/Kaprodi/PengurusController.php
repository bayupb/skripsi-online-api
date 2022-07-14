<?php

namespace App\Http\Controllers\Kaprodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\DospemRepo;
use App\Repositories\Kaprodi\PengurusRepo;

class PengurusController extends Controller
{
    public PengurusRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new PengurusRepo();
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
            'email' => $req->input('email'),
            'password' => $req->input('password'),
        ];

        $data = $this->skripsi->getSimpan($req);
        return $data;
    }

    public function getHapus($pengurusId)
    {
        $data = [
            'pengurus_id' => $pengurusId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
