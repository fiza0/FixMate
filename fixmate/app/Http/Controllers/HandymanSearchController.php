<?php

namespace App\Http\Controllers;

use App\Models\HandymanProfile;
use Illuminate\Http\Request;

class HandymanSearchController extends Controller
{
    /**
     * Display a listing of handymen with optional filters.
     */
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

        $handymen = $query->paginate(12);

        return view('handymen.index', compact('handymen'));
    }
}
