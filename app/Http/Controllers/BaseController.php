<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{    
    public function sendSuccessResponse($data, $statusCode = 200, $messages = [])
    {
        return response()->json([
            'success' => true,
            'statusCode' => $statusCode,
            'messages' => $messages,
            'data' => $data,
        ], $statusCode);
    }

    public function sendErrorResponse($errors = [], $statusCode = 500) 
    {
        return response()->json([
            'success' => false,
            'statusCode' => $statusCode,
            'errors' => $errors,
        ], $statusCode);
    }
}
