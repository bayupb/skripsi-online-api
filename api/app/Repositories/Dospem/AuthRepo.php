<?php namespace App\Repositories\Dospem;

use App\Models\Dospem;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Auth;

class AuthRepo
{
    public function getLogin($params)
    {
        $nidn = isset($params['nidn']) ? $params['nidn'] : '';
        if (strlen($nidn) == 0) {
            return ResponseHelpers::ResponseError(
                404,
                'Nidn tidak boleh kosong'
            );
        }
        $password = isset($params['password']) ? $params['password'] : '';
        if (strlen($password) == 0) {
            return ResponseHelpers::ResponseError(
                404,
                'Password tidak boleh kosong'
            );
        }

        $admin = Dospem::where('nidn', $nidn)->first();

        if (!$admin) {
            return ResponseHelpers::ResponseError(400, 'Nidn not found');
        }
        if (
            !Dospem::where([
                'nidn' => $nidn,
                'password' => $password,
            ])
        ) {
            return ResponseHelpers::ResponseError(
                'Invalid email or password',
                400
            );
        }

        $credentials = $params->only(['nidn', 'password']);
        if (
            !($token = auth()
                ->guard('api_dospem')
                ->attempt($credentials))
        ) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return ResponseHelpers::ResponseLogin(200, $admin, $token);
    }

    public function getUser()
    {
        try {
            // $data = auth()
            //     ->guard('api_dospem')
            //     ->user();
            return ResponseHelpers::ResponseSucces(200, true, auth()->user());

            // return ResponseHelpers::ResponseSucces(200, 'Personal Data', $data);
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }

    public function getLogout()
    {
        try {
            Auth::logout();
            return ResponseHelpers::ResponseSucces(200, 'Logout success', []);
        } catch (\Throwable $th) {
            return ResponseHelpers::ResponseError(400, $th->getMessage());
        }
    }
}
