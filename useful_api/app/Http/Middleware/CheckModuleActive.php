<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Module;
class CheckModuleActive
{
//     public function handle($request, Closure $next, $moduleId): Response
//     {
//         $user = Auth::user();

//         $module = Module::where('name', $moduleName)->first();

//         if (! $module) {
//             return response()->json(['error' => 'Module inconnu'], 404);
//         }

//         $isActive = $user->modules()
//             ->where('module_id', $module->id)
//             ->wherePivot('active', true)
//             ->exists();


//         if (! $isActive) {
//             return response()->json(['error' => 'Module inactive. Please activate this module to use it.'], 403);
//         }

//         return $next($request);
//     }


public function handle($request, Closure $next, $moduleId): Response
{
    $user = Auth::user();

    // Vérifie si le module existe et est actif
    $isActive = $user->modules()
        ->where('module_id', $moduleId)
        ->wherePivot('active', true)
        ->exists();

    // Récupère le module par ID pour vérifier son existence
    $module = Module::find($moduleId);
    if (! $module) {
        return response()->json(['error' => 'Module inconnu'], 404);
    }

    if (! $isActive) {
        return response()->json(['error' => 'Module inactive. Please activate this module to use it.'], 403);
    }

    return $next($request);
}  
}
