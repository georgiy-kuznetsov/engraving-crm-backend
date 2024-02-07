<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormatResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->setData([
            'statusCode' => $response->getStatusCode(),
            'success' => $request->isSuccess ?? true,
            'message' => $request->message ?? '',
            'errors' => $request->errors ?? [],
            'data' => $response->getData(true),
        ]);
        return $response;
    }
}
