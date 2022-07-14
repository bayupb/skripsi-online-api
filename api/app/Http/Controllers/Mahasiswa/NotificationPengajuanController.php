<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Repositories\Mahasiswa\NotificationPengajuanRepo;

class NotificationPengajuanController extends Controller
{
    public NotificationPengajuanRepo $skripsi;

    public function __construct()
    {
        $this->skripsi = new NotificationPengajuanRepo();
    }

    public function getList()
    {
        $data = $this->skripsi->getlist();
        return $data;
    }
}
