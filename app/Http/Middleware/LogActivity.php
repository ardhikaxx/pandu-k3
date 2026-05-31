<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $module = explode('/', $request->path())[1] ?? 'system';
            
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => strtolower($request->method()),
                'module' => $module,
                'description' => "User melakukan aks " . $request->method() . " pada path: " . $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'new_values' => $request->except(['password', 'password_confirmation', '_token', '_method']),
            ]);
        }

        return $response;
    }
}
