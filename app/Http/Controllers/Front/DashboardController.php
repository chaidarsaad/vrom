<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $rent =  Booking::with(['item.brand', 'user'])->where('user_id', Auth::user()->id)->get()->reverse();
        $hero = Item::with(['type', 'brand'])->latest()->first();

        return view('dashboard', [
            'rent' => $rent,
            'hero' => $hero
        ]);
    }

    public function detail(Request $request, $orderId)
    {
        $detail =  Booking::with(['item.brand', 'user'])->where('booking_code', $orderId)->where('user_id', Auth::id())->firstOrFail();
        return view('orderdetail', [
            'detail' => $detail
        ]);
    }
}
