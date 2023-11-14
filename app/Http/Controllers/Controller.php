<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function successfullResponse($data)
    {
        return response()->json(['data' => $data], 200);
    }

    public function failResponse($message)
    {
        return response()->json([
            'error' => $message,
        ], 500);
    }

    public function notFoundResponse($message)
    {
        return response()->json([
            'error' => $message,
        ], 404);
    }
}
