<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDivisionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Admins and HSE Managers can see all divisions within their company
        if (in_array($user->role, ['super_admin', 'hse_manager'])) {
            return $next($request);
        }

        // For other roles, ensure they have a division assigned
        if (!$user->division_id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki divisi.');
        }

        // Logic to filter data would typically be in a Scope or Policy,
        // but this middleware can enforce a general check if needed.
        
        return $next($request);
    }
}
