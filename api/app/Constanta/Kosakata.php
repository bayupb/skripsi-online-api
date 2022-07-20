<?php

namespace App\Constanta;

class Kosakata
{
    const DATA_BERHASIL_DISIMPAN = 'Berhasil menyimpan data '; //value example simpan akun : $value->name
    const DATA_BERHASIL_DITEMUKAN = 'Data berhasil ditemukan';
    const DATA_TIDAK_DITEMUKAN = 'Data tidak ditemukan';
    const DATA_BERHASIL_DIHAPUS = 'Data berhasil di hapus';
    const DATA_SUDAH_DIHAPUS = 'Data ini sudah dihapus';

    const DATA_TELAH_BERELASI = 'Data ini sedang berelasi';
    const AKUN_TELAH_LOGIN = 'Anda berhasil login';
    const AKUN_TELAH_KELUAR = 'Anda berhasil keluar';

    const DATA_AKUN_MAHASISWA_BELUM_DIVERIFIKASI = 'Akun anda belum diverifikasi, silahkan tunggu sampai akun anda berhasil di verifikasi';

    // notification text message
    const NOTIFIICATION_BERHASIL = 'Notifikasi telah dikirimkan';

    public static function requiredFields(
        $status = 404,
        $value,
        $message = 'tidak boleh kosong'
    ) {
        return response()->json([
            'status' => $status,
            'message' => $value . $message,
        ]);
    }
}
