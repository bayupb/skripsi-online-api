<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Dospem;

class GeneratorHelpers
{
    public static function GeneratorUnique($value)
    {
        return Carbon::now()->format('Ymd') .
            str_pad(1, 1, $value, STR_PAD_LEFT);
    }
    public static function GeneratorUuid($value)
    {
        return Carbon::now()->format('YmdHis') .
            str_pad($value + 1, 2, '2', STR_PAD_LEFT);
    }
}
