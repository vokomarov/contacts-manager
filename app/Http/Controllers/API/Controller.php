<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    /**
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbidden(?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? 'You are not allowed to perform this action',
        ], Response::HTTP_FORBIDDEN);
    }
}
