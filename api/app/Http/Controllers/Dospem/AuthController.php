<?php

namespace App\Http\Controllers\Dospem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Dospem\AuthRepo;

class AuthController extends Controller
{
    public AuthRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new AuthRepo();
    }

    public function getLogin(Request $req)
    {
        $data = [
            'nidn' => $req->input('nidn'),
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
