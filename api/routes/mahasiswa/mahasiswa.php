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
Route::prefix('mahasiswa')->group(function () {
    Route::prefix('login')->group(function () {
        Route::post('/', [
            App\Http\Controllers\Mahasiswa\AuthController::class,
            'getLogin',
        ]);
    });
    Route::prefix('registrasi')->group(function () {
        Route::post('/', [
            App\Http\Controllers\Mahasiswa\AuthController::class,
            'getRegister',
        ]);
    });
    Route::group(['middleware' => 'auth:api_mahasiswa'], function () {
        Route::prefix('user')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Mahasiswa\AuthController::class,
                'getUser',
            ]);
        });
        Route::prefix('refresh')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Mahasiswa\AuthController::class,
                'refreshToken',
            ]);
        });
        Route::prefix('logout')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Mahasiswa\AuthController::class,
                'getLogout',
            ]);
        });
        Route::prefix('pengajuan-skripsi')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Mahasiswa\PengajuanSkripsiController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Mahasiswa\PengajuanSkripsiController::class,
                'getSimpan',
            ]);
            Route::delete('/{pengajuanSkripsiId}/hapus', [
                App\Http\Controllers\Mahasiswa\PengajuanSkripsiController::class,
                'getHapus',
            ]);
        });
        Route::prefix('notifikasi')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Mahasiswa\NotificationPengajuanController::class,
                'getList',
            ]);
        });
    });
});
