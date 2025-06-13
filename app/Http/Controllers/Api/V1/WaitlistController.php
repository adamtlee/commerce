<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Waitlist;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    public function index()
    {
        $waitlists = Waitlist::with(['product'])->get();
        return response()->json($waitlists);
    }

    public function show(Waitlist $waitlist)
    {
        $waitlist->load(['product']);
        return response()->json($waitlist);
    }
} 