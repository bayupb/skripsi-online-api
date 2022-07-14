<?php

namespace App\Http\Controllers\Pengurus;
use App\Http\Controllers\Controller;
use App\Repositories\Pengurus\MappingDosenMahasiswa;
use Illuminate\Http\Request;

class MappingDosenMahasiswaController extends Controller
{
    public MappingDosenMahasiswa $skripsi;

    public function __construct()
    {
        $this->skripsi = new MappingDosenMahasiswa();
    }

    public function getMahasiswaPengajuanAcc()
    {
        $data = $this->skripsi->getMahasiswaPengajuanAcc();
        return $data;
    }
    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }

    public function getSimpan(Request $req)
    {
        $data = [
            'mapping_mahasiswa_dospem_id' => $req->input(
                'mapping_mahasiswa_dospem_id'
            ),
            'mahasiswa_id' => $req->input('mahasiswa_id'),
            'dospem_1_id' => $req->input('dospem_1_id'),
            'dospem_2_id' => $req->input('dospem_2_id'),
        ];

        $data = $this->skripsi->getSimpan($data);
        return $data;
    }

    public function getHapus($mappingDosenMahasiswaId)
    {
        $data = [
            'mapping_mahasiswa_dospem_id' => $mappingDosenMahasiswaId,
        ];
        $data = $this->skripsi->getHapus($data);
        return $data;
    }
}
