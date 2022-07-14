<?php

namespace App\Http\Controllers\Kaprodi;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\FakultasRepo;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    public FakultasRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new FakultasRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }

    public function getSimpan(Request $req)
    {
        $data = [
            'fakultas_id' => $req->input('fakultas_id'),
            'singkat' => $req->input('singkat'),
            'nama_fakultas' => $req->input('nama_fakultas'),
        ];

        $data = $this->skripsi->getSimpan($data);
        return $data;
    }

    public function getHapus($fakultasId)
    {
        $data = [
            'fakultas_id' => $fakultasId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
