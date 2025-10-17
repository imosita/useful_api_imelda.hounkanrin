<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function activate($id)
    {
        $module = Module::findOrFail($id);
        auth()->user()->modules()->syncWithoutDetaching([$id => ['active' => true]]);
        return response()->json(['message' => 'Module activated']);
    }

    public function deactivate($id)
    {
        $module = Module::findOrFail($id);
        auth()->user()->modules()->updateExistingPivot($id, ['active' => false]);
        return response()->json(['message' => 'Module deactivated']);
    }
    // public function index()
    // {
    //     $modules = Module::all(['id', 'name', 'description']);

    //     // return response()->json($modules, 200);

    //     return [
    //         'id'         => $modules->id,
    //         'name'       => $modules->name,
    //         'description' =>$modules->description
    //     ];
    // }


    public function index()
    {
        $modules = Module::all(['id', 'name', 'description']);

        return response()->json($modules, 200);
    }
}


// public function index()
// {
//     $user = auth()->user();
//     $modules = Module::all();
//     return response()->json($modules->map(function ($module) use ($user) {
//         return [
//             'id' => $module->id,
//             'name' => $module->name,
//             'active' => $user->modules->contains($module) && $user->modules->find($module->id)->pivot->active
//         ];
//     }));
// }   