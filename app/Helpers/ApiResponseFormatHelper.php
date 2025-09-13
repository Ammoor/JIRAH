<?php

namespace App\Helpers;

class ApiResponseFormatHelper
{
    public static function successResponse(int $responseCode, string $responseMessage, $responseData = [], array $responseMeta = [])
    {
        $response = [
            'status_code' => $responseCode,
            'message' => $responseMessage,
            'data' => $responseData,
            'meta_data' => $responseMeta,
        ];
        return response()->json($response, $responseCode);
    }
    public static function failedResponse(int $responseCode, $responseErrors, $responseMessage = 'Failed')
    {
        $response = [
            'status_code' => $responseCode,
            'message' => $responseMessage,
            'errors' => $responseErrors,
        ];
        return response()->json($response, $responseCode);
    }
}
