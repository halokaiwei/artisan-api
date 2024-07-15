<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ipaddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ipyes = ['127.0.0.1'];
        $clientIp = $request->ip();

        if (!in_array($clientIp, $ipyes)) {
            return response()->json(['error' => 'IP unauthorized'], 403);
        }

        return $next($request);
    }
}
