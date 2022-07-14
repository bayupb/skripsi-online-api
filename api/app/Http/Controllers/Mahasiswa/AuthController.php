<?php

namespace App\Http\Controllers\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mahasiswa\AuthRepo;

class AuthController extends Controller
{
    public AuthRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new AuthRepo();
    }

    public function getRegister(Request $req)
    {
        $data = [
            'email' => $req->input('email'),
            'username' => $req->input('username'),
            'jenis_kelamin' => $req->input('jenis_kelamin'),
            'fakultas_id' => $req->input('fakultas_id'),
            'nimn' => $req->input('nimn'),
            'password' => $req->input('password'),
        ];

        $data = $this->skripsi->getRegister($req);
        return $data;
    }
    public function getLogin(Request $req)
    {
        $data = [
            'nimn' => $req->input('nimn'),
            'password' => $req->input('password'),
        ];

        $data = $this->skripsi->getLogin($req);
        return $data;
    }

    public function getUser()
    {
        $data = $this->skripsi->getUser();
        return $data;
    }

    public function getLogout()
    {
        $data = $this->skripsi->getLogout();
        return $data;
    }
}
