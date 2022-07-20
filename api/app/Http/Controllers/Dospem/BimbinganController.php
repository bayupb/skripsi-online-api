<?php

namespace App\Http\Controllers\Dospem;

use App\Http\Controllers\Controller;
use App\Repositories\Dospem\BimbinganRepo;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    // public ;

    public function __construct(BimbinganRepo $skripsi)
    {
        $this->skripsi = new BimbinganRepo();
    }
    public function getList()
    {
        $data = $this->skripsi->getList();
        return $data;
    }
    public function getSimpan(Request $request)
    {
        $data = [
            'nama_bimbingan' => $request->input('nama_bimbingan'),
            'tempat_bimbingan' => $request->input('tempat_bimbingan'),
            'tanggal_bimbingan' => $request->input('tanggal_bimbingan'),
            'jam_bimbingan' => $request->input('jam_bimbingan'),
        ];

        $data = $this->skripsi->getSimpan($request);
        return $data;
    }

    public function getHapus($bimbinganId)
    {
        $data = ['bimbingan_id' => $bimbinganId];

        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
