<?php

namespace App\Http\Controllers\Kaprodi;
use App\Http\Controllers\Controller;
use App\Repositories\Kaprodi\VerifikasimahasiswaRepo;
use Illuminate\Http\Request;

class VerifikasiMahasiswaController extends Controller
{
    public VerifikasimahasiswaRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new VerifikasimahasiswaRepo();
    }

    public function getDataNonVerifikasiMahasiswa()
    {
        $data = $this->skripsi->getDataNonVerifikasiMahasiswa();
        return $data;
    }
    public function getDataVerifikasiMahasiswa()
    {
        $data = $this->skripsi->getDataVerifikasiMahasiswa();
        return $data;
    }

    public function getMelakukanVerifikasiMahasiswa($mahasiswaId)
    {
        $data = [
            'mahasiswa_id' => $mahasiswaId,
        ];
        $data = $this->skripsi->getMelakukanVerifikasiMahasiswa($data);
        return $data;
    }
}
