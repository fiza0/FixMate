<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HandymanProfile;
use Illuminate\Http\Request;

class HandymanApiController extends Controller
{
    public function index(Request $request)
    {
        $query = HandymanProfile::with('user');

        if ($request->filled('skill')) {
            $query->where('skill_category', 'like', '%' . $request->skill . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('min_rating')) {
            $query->where('average_rating', '>=', $request->min_rating);
        }

        return response()->json($query->paginate(20));
    }
}
