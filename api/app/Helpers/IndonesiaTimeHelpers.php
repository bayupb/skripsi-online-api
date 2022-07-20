<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;

class IndonesiaTimeHelpers
{
    public static function IndonesiaDate($value)
    {
        $ibukota = 'Asia/Jakarta';
        $tanggal = Date('Y-m-d');
        $waktu = Date('H:i:s');
        $singkronisasi = new DateTime($tanggal . ' ' . $waktu);
        $singkronisasi->setTimezone(new DateTimeZone($ibukota));

        return $singkronisasi->format('Y-m-d H:i:s');
    }
    public static function tanggalIndonesiaDate($value)
    {
        $ibukota = 'Asia/Jakarta';
        $tanggal = Date('Y-m-d');
        $singkronisasi = new DateTime($tanggal);
        $singkronisasi->setTimezone(new DateTimeZone($ibukota));

        return $singkronisasi->format('Y-m-d');
    }
    public static function jamIndonesiaDate($value)
    {
        $ibukota = 'Asia/Jakarta';
        $waktu = Date('H:i:s');
        $singkronisasi = new DateTime($waktu);
        $singkronisasi->setTimezone(new DateTimeZone($ibukota));

        return $singkronisasi->format('H:i:s');
    }
}
