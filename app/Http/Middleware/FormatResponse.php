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
            'success' => ($response->getStatusCode() > 399) ? false : true,
            'message' => $request->get('message') ?? '',
            'errors' => $request->errors ?? [],
            'data' => $response->getData(true),
        ]);
        return $response;
    }
}
