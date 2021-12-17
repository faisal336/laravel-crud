<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function sendResponse(string $message, array $data = [], int $code = 200): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $message, array $data = [], int $code = 400): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['errors'] = $data;
        }

        return response()->json($response, $code);
    }
}
