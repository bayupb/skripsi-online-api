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
Route::prefix('pengurus')->group(function () {
    Route::prefix('login')->group(function () {
        Route::post('/', [
            App\Http\Controllers\Pengurus\AuthController::class,
            'getLogin',
        ]);
    });
    Route::prefix('registrasi')->group(function () {
        Route::post('/', [
            App\Http\Controllers\Pengurus\AuthController::class,
            'getRegister',
        ]);
    });
    Route::group(['middleware' => 'auth:api_pengurus'], function () {
        Route::prefix('user')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Pengurus\AuthController::class,
                'getUser',
            ]);
        });
        Route::prefix('refresh')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Pengurus\AuthController::class,
                'refreshToken',
            ]);
        });
        Route::prefix('logout')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Pengurus\AuthController::class,
                'getLogout',
            ]);
        });
        // pengacc an data dosen dan mahasiswa
        Route::prefix('mapping-dospem')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Pengurus\MappingDosenMahasiswaController::class,
                'getList',
            ]);
            Route::get('/acc-mahasiswa', [
                App\Http\Controllers\Pengurus\MappingDosenMahasiswaController::class,
                'getMahasiswaPengajuanAcc',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Pengurus\MappingDosenMahasiswaController::class,
                'getSimpan',
            ]);
            Route::post('/{mappingDosenMahasiswaId}/hapus', [
                App\Http\Controllers\Pengurus\MappingDosenMahasiswaController::class,
                'getHapus',
            ]);
        });
    });
});
