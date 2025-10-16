<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    public function handle($request, Closure $next, $moduleName): Response
    {
        $user = Auth::user();

        $module = Module::where('name', $moduleName)->first();

        if (! $module) {
            return response()->json(['error' => 'Module inconnu'], 404);
        }

        $isActive = $user->modules()
            ->where('module_id', $module->id)
            ->wherePivot('active', true)
            ->exists();

        if (! $isActive) {
            return response()->json(['error' => 'Module inactive. Please activate this module to use it.'], 403);
        }

        return $next($request);
    }
}   