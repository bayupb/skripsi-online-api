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
Route::prefix('dospem')->group(function () {
    Route::prefix('login')->group(function () {
        Route::post('/', [
            App\Http\Controllers\Dospem\AuthController::class,
            'getLogin',
        ]);
    });
    Route::group(['middleware' => 'auth:api_dospem'], function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Dospem\AuthController::class,
                'getUser',
            ]);
        });
        Route::prefix('refresh')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Dospem\AuthController::class,
                'refreshToken',
            ]);
        });
        Route::prefix('logout')->group(function () {
            Route::post('/', [
                App\Http\Controllers\Dospem\AuthController::class,
                'getLogout',
            ]);
        });

        // bimbingan dospem to mahasiswa fakultas
        Route::prefix('bimbingan')->group(function () {
            Route::get('/', [
                App\Http\Controllers\Dospem\BimbinganController::class,
                'getList',
            ]);
            Route::post('/simpan', [
                App\Http\Controllers\Dospem\BimbinganController::class,
                'getSimpan',
            ]);
            Route::post('/{bimbinganId}/hapus', [
                App\Http\Controllers\Dospem\BimbinganController::class,
                'getHapus',
            ]);
        });
    });
});
