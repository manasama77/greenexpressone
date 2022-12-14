<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessages = null, $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'data'    => $errorMessages,
        ];

        return response()->json($response, $code);
    }
}
