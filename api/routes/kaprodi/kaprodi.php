<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('kaprodi')->group(function () {
    Route::prefix('login')->group(function () {
        Route::post('/', [
            App\Http\Controllers\Kaprodi\AuthController::class,
            'getLogin',
        ]);
    });
    Route::group(['middleware' => 'auth:api_kaprodi'], function () {
        Route::prefix('user')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Kaprodi\AuthController::class,
                'getUser',
            ]);
        });
        Route::prefix('refresh')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Kaprodi\AuthController::class,
                'refreshToken',
            ]);
        });
        Route::prefix('logout')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Kaprodi\AuthController::class,
                'getLogout',
            ]);
        });
        // fakultas
        Route::prefix('fakultas')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Kaprodi\FakultasController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Kaprodi\FakultasController::class,
                'getSimpan',
            ]);
            Route::delete('/{fakultasId}/hapus', [
                App\Http\Controllers\Kaprodi\FakultasController::class,
                'getHapus',
            ]);
        });
        // gelombang skripsi
        Route::prefix('gelombang-skripsi')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Kaprodi\GelombangSkripsiController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Kaprodi\GelombangSkripsiController::class,
                'getSimpan',
            ]);
            Route::delete('/{gelombangSkripsiId}/hapus', [
                App\Http\Controllers\Kaprodi\GelombangSkripsiController::class,
                'getHapus',
            ]);
        });
        // dospem
        Route::prefix('dospem')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Kaprodi\DospemController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Kaprodi\DospemController::class,
                'getSimpan',
            ]);
            Route::delete('/{dospemId}/hapus', [
                App\Http\Controllers\Kaprodi\DospemController::class,
                'getHapus',
            ]);
        });
        // pengurus
        Route::prefix('pengurus-skripsi')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Kaprodi\PengurusController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Kaprodi\PengurusController::class,
                'getSimpan',
            ]);
            Route::delete('/{pengurusId}/hapus', [
                App\Http\Controllers\Kaprodi\PengurusController::class,
                'getHapus',
            ]);
        });
        // mahasiswa
        Route::prefix('mahasiswa')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Kaprodi\MahasiswaController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Kaprodi\MahasiswaController::class,
                'getSimpan',
            ]);
            Route::delete('/{mahasiswaId}/hapus', [
                App\Http\Controllers\Kaprodi\MahasiswaController::class,
                'getHapus',
            ]);
        });
        // verifikasi akun mahasiswa untuk aktif
        Route::prefix('verifikasi-mahasiswa')->group(function () {
            Route::get('/belum-aktif', [
                App\Http\Controllers\Kaprodi\VerifikasiMahasiswaController::class,
                'getDataNonVerifikasiMahasiswa',
            ]);
            Route::get('/aktif', [
                App\Http\Controllers\Kaprodi\VerifikasiMahasiswaController::class,
                'getDataVerifikasiMahasiswa',
            ]);
            Route::post('/{mahasiswaId}/verifikasi', [
                App\Http\Controllers\Kaprodi\VerifikasiMahasiswaController::class,
                'getMelakukanVerifikasiMahasiswa',
            ]);
        });
        // verifikasi pengajuan skripsi
        Route::prefix('verifikasi-pengajuan-skripsi')->group(function () {
            Route::get('/all', [
                App\Http\Controllers\Kaprodi\VerifikasiPengajuanSkripsiController::class,
                'getDataAllVerifikasiPengajuan',
            ]);
            Route::get('/tolak', [
                App\Http\Controllers\Kaprodi\VerifikasiPengajuanSkripsiController::class,
                'getDataDitolakVerifikasiPengajuan',
            ]);
            Route::get('/revisi', [
                App\Http\Controllers\Kaprodi\VerifikasiPengajuanSkripsiController::class,
                'getDataDirevisiPengajuan',
            ]);
            Route::get('/acc', [
                App\Http\Controllers\Kaprodi\VerifikasiPengajuanSkripsiController::class,
                'getDataDiterimaPengajuan',
            ]);
            Route::post('/{pengajuanSkripsiId}/verifikasi', [
                App\Http\Controllers\Kaprodi\VerifikasiPengajuanSkripsiController::class,
                'getMelakukanVerifikasiPengajuan',
            ]);
        });
    });
});
