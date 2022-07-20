<?php namespace App\Repositories\Mahasiswa;

use Carbon\Carbon;
use App\Models\Mahasiswa;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Hash;
use App\Helpers\IndonesiaTimeHelpers;
use Facade\FlareClient\Http\Response;

class AuthRepo
{
    public function getRegister($params)
    {
        try {
            $nimn = isset($params['nimn']) ? $params['nimn'] : '';
            if (strlen($nimn) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nimn tidak boleh kosong'
                );
            }
            $jenisKelamin = isset($params['jenis_kelamin'])
                ? $params['jenis_kelamin']
                : '';
            if (strlen($jenisKelamin) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Jenis Kelamin tidak boleh kosong'
                );
            }
            $fakultasId = isset($params['fakultas_id'])
                ? $params['fakultas_id']
                : '';
            if (strlen($fakultasId) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Fakultas tidak boleh kosong'
                );
            }
            $mahasiswaNimn = Mahasiswa::query()
                ->where('nimn', $nimn)
                ->first();
            if (!is_null($mahasiswaNimn)) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Nimn sudah digunakan, silahkan gunakan nimn asli mahasiswa anda!'
                );
            }
            $username = isset($params['username']) ? $params['username'] : '';
            if (strlen($username) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Username tidak boleh kosong'
                );
            }
            $email = isset($params['email']) ? $params['email'] : '';
            if (strlen($email) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Email tidak boleh kosong'
                );
            }
            $password = isset($params['password']) ? $params['password'] : '';
            if (strlen($password) == 0) {
                return ResponseHelpers::ResponseError(
                    404,
                    'Password tidak boleh kosong'
                );
            }

            $data = new Mahasiswa();
            $data->dibuat_pada = IndonesiaTimeHelpers::IndonesiaDate(
                Carbon::now()
            );
            $data->username = $username;
            $data->email = $email;
            $data->password = Hash::make($password);
            $data->nimn = $nimn;
            $data->jenis_kelamin = $jenisKelamin;
            $data->fakultas_id = $fakultasId;
            $data->aktif_mahasiswa = 0;
            $data->save();

            return ResponseHelpers::ResponseSucces(
                200,
                'Akun anda berhasil dibuat, silahkan tunggu verifikasi',
                $data
            );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }
    public function getLogin($params)
    {
        $nimn = isset($params['nimn']) ? $params['nimn'] : '';
        if (strlen($nimn) == 0) {
            return ResponseHelpers::ResponseError(
                404,
                'Nimn tidak boleh kosong'
            );
        }
        $password = isset($params['password']) ? $params['password'] : '';
        if (strlen($password) == 0) {
            return ResponseHelpers::ResponseError(
                404,
                'Password tidak boleh kosong'
            );
        }

        $data = Mahasiswa::where('nimn', $nimn)->first();

        if (!$data) {
            return ResponseHelpers::ResponseError(400, 'Nimn not found');
        }
        if (
            !Mahasiswa::where([
                'nimn' => $nimn,
                'password' => $password,
                'aktif_password' => 1,
            ])
        ) {
            return ResponseHelpers::ResponseError(
                'Invalid nimn or password',
                400
            );
        }
        if (!$data->aktif_mahasiswa == 1) {
            return ResponseHelpers::ResponseError(
                404,
                'Akun anda belum diverifikasi oleh kaprodi'
            );
        }

        $credentials = $params->only(['nimn', 'password']);
        if (
            !($token = auth()
                ->guard('api_mahasiswa')
                ->attempt($credentials))
        ) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return ResponseHelpers::ResponseLogin(
            200,
            auth()
                ->guard('api_mahasiswa')
                ->user(),
            $token
        );
    }

    public function getUser()
    {
        try {
            return ResponseHelpers::ResponseSucces(200, true, auth()->user());
            // return response()->json(
            //     [
            //         'success' => true,
            //         'user' => auth()
            //             ->guard('api_mahasiswa')
            //             ->user(),
            //     ],
            //     200
            // );
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }

    public function getLogout()
    {
        auth()->logout();
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }
}
