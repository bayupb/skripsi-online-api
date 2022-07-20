<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Repositories\Mahasiswa\NotificationDospemRepo;

class NotificationDospemController extends Controller
{
    public NotificationDospemRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new NotificationDospemRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }
}
