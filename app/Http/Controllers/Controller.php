<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Respuesta exitosa unificada.
     * Cubre los casos de: Index, Show, Store y Update.
     */
    public function sendResponse($data, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'error'   => false,
            'status'  => $code,
        ], $code);
    }

    /**
     * Respuesta de error unificada.
     * Cubre los casos de: 404 Not Found, 400 Bad Request, etc.
     */
    public function sendError(string $message,int $code = 404,$data = null): JsonResponse
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'error'   => true,
            'status'  => $code,
        ], $code);
    }

    /**
     * Respuesta para eliminaciones exitosas (Destroy).
     * Normalmente no devuelven 'data', pero mantienen la estructura.
     */
    public function sendDeleteResponse(string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error'   => false,
            'status'  => 200,
        ], 200);
    }
}