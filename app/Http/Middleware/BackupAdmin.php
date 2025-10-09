<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
class BackupAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['administrador','supervisor'])) {
            return redirect('/home');
        }else{
            $permisos = $user->getAllPermissions();
            $filtered = $permisos->filter(function (Permission $value, int $key) {
                return $value->name = "crear backup";
            });
            if($filtered->count() == 0){
                return redirect('/home');
            }else{
                return $next($request);
            }
        }
    }
}