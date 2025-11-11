<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HandymanProfile;

class HandymanApiController extends Controller
{
    public function index(Request $request)
    {
        $query = HandymanProfile::with('user');

        if($request->filled('skill')){
            $query->where('skill_category', $request->skill);
        }
        if($request->filled('location')){
            $query->where('location', 'ilike', "%{$request->location}%"); // PostgreSQL ilike
        }

        $handymen = $query->whereHas('user', fn($q) => $q->where('verified', true))
                          ->orderByDesc('average_rating')
                          ->paginate(12);

        return response()->json($handymen);
    }

    public function show($id)
    {
        $handyman = HandymanProfile::with(['user','user.bookingsAsHandyman','user.bookingsAsHandyman.review'])
                    ->findOrFail($id);
        return response()->json($handyman);
    }
}
