<?php

namespace Agicom\Sweepbright\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SweepbrightMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = json_encode($request->all());
        $key = config('sweepbright.client_secret');
        $result = hash_hmac('sha1', $data, $key);

        return $result === $request->header('X-Hook-Signature') ? $next($request) : false;
    }
}
