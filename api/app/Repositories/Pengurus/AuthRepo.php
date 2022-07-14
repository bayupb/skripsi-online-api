<?php namespace App\Repositories\Pengurus;

use App\Helpers\ResponseHelpers;
use App\Models\Pengurus;

class AuthRepo
{
    public function getLogin($params)
    {
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

        $admin = Pengurus::where('email', $email)->first();

        if (!$admin) {
            return ResponseHelpers::ResponseError(400, 'email not found');
        }
        if (
            !Pengurus::where([
                'email' => $email,
                'password' => $password,
            ])
        ) {
            return ResponseHelpers::ResponseError(
                'Invalid email or password',
                400
            );
        }

        $credentials = $params->only(['email', 'password']);
        if (
            !($token = auth()
                ->guard('api_pengurus')
                ->attempt($credentials))
        ) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return ResponseHelpers::ResponseLogin(
            200,
            auth()
                ->guard('api_pengurus')
                ->user(),
            $token
        );
    }

    public function getUser()
    {
        return response()->json(
            [
                'success' => true,
                'user' => auth()
                    ->guard('api_pengurus')
                    ->user(),
            ],
            200
        );
    }

    public function getLogout()
    {
        auth()->logout();
        return ResponseHelpers::ResponseSucces(200, 'Logout success', []);
        //response "success" logout
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }
}
