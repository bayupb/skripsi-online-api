<?php

namespace App\Helpers;

class ResponseHelpers
{
    public static function ResponseSucces($status = 200, $message, $data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
    public static function ResponseLogin($status = 200, $user, $token)
    {
        return response()->json([
            'status' => $status,
            'user' => $user,
            'token' => $token,
        ]);
    }
    public static function ResponseSuccesFile($message, $data)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ]);
    }
    public static function ResponseError($status = 400, $message)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
