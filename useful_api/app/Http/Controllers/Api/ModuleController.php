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
}
