<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    public static function rollback($e, $message = "Something went wrong! Process not completed", $code = 500): JsonResponse
    {
        Log::error($e);
        DB::rollBack();

        if ($e instanceof ModelNotFoundException) {
            self::throw($e, 'Resource not found', 404);
        }

        self::throw($e, $message, $code);
    }

    public static function throw($e, $message = "Something went wrong! Process not completed", $code = 500)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e->getMessage() ?? 'Error',
        ], $code));
    }

    public static function sendResponse($result, $message=null, $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }

}
