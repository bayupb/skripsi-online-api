<?php

namespace App\Repositories;

use App\Helpers\ResponseHelpers;
use App\Models\Kaprodi;

class KaprodiRepo
{
    public function getList()
    {
        try {
            $data = Kaprodi::query()->get();
            return ResponseHelpers::ResponseSucces(
                200,
                'Sukses mengambil data',
                $data
            );
        } catch (\Throwable $th) {
            ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }
}
