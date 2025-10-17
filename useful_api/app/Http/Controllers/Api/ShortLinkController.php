<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    public function index()
    {
        $links = auth()->user()->shortLinks()->get()->map(function ($link) {
            return [
                'id'           => $link->id,
                'original_url' => $link->original_url,
                'code'         => $link->code,
                'clicks'       => $link->clicks,
                'created_at'   => $link->created_at->toISOString(),
            ];
        });

        return response()->json($links, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'custom_code'  => 'nullable|string|max:10|regex:/^[a-zA-Z0-9_\-]+$/|unique:shortlinks,code',
        ]);
        $code = $request->custom_code ?? Str::random(6);
        $link = auth()->user()->shortLinks()->create([
            'original_url' => $request->original_url,
            'code'         => $code,
            'clicks'       => 0,
        ]);
        $link->refresh();

        return response()->json([
            'id'           => $link->id,
            'user_id'      => $link->user_id,
            'original_url' => $link->original_url,
            'code'         => $link->code,
            'clicks'       => $link->clicks,
            'created_at'   => $link->created_at,
        ], 201);
    }

    public function redirect($code)
    {
        $link = ShortLink::where('code', $code)->firstOrFail();
        // $link->incrementClicks();
        $link->increment('clicks');
        return redirect($link->original_url, 302);
    }

    public function destroy($id)
    {
        $link = ShortLink::findOrFail($id);

        if ($link->user_id != auth()->id()) {
            return response()->json(['error' => 'Accès refusé'], 403);
        }

        $link->delete();
        return response()->json(['message' => 'Link deleted successfully']);
    }
}
