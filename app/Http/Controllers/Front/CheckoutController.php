<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(Request $request, $slug)
    {
        $item = Item::with(['type', 'brand'])->whereSlug($slug)->firstOrFail();

        return view('checkout', [
            'item' => $item
        ]);
    }

    public function store(Request $request, $slug)
    {
        $val = Item::with('type')->whereSlug($slug)->firstOrFail();

        if ($val->type->name == 'Microbus') {
            $request->validate([
                'name' => 'required',
                'number_phone' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'with_delivery' => 'required',
                'with_driver' => 'required',
                'address' => 'required',
                'city' => 'required'
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'number_phone' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'with_delivery' => 'required',
                'with_driver' => 'required',
                'address' => 'required_if:with_delivery,Yes with delivery',
                'city' => 'required_if:with_delivery,Yes with delivery'
            ]);
        }

        // Format start_date and end_date from dd mm yyyy to timestamp
        $start_date = Carbon::createFromFormat('d m Y', $request->start_date);
        $end_date = Carbon::createFromFormat('d m Y', $request->end_date);

        // Count the number of days between start_date and end_date
        $days = $start_date->diffInDays($end_date);

        // Get the item
        $item = Item::whereSlug($slug)->firstOrFail();

        // generate code booking
        $code = 'trx-' . mt_rand(0000, 9999);

        // driver
        $driver = 90000 * $days;

        // Calculate the total price
        if ($request->with_driver == 'Yes with driver') {
            $total_price = $days * $item->price + $driver;
        } else {
            $total_price = $days * $item->price;
        }
        Log::info('Total price: ' . $total_price);


        $tax_rate = 0.11; // 11% pajak
        $tax_amount = $total_price * $tax_rate;
        $total_price_with_tax = $total_price + $tax_amount;


        // check date
        $tanggalStartCek = $request->start_date;
        $tanggalEndCek = $request->end_date;
        $convertedStartDate = Carbon::createFromFormat('d m Y', $tanggalStartCek)->format('Y-m-d');
        $convertedEndDate = Carbon::createFromFormat('d m Y', $tanggalEndCek)->format('Y-m-d');

        $startExists = Booking::where('start_date', $convertedStartDate)->where('item_id', $item->id)->exists();
        $endExists = Booking::where('start_date', $convertedEndDate)->where('item_id', $item->id)->exists();

        if ($startExists || $endExists) {
            Alert::error('Oopss', 'Sudah terbooking, silahkan pilih tanggal lain!!!');
            return redirect()->back();
        } else {
            // Create a new booking
            $booking = $item->bookings()->create([
                'name' => $request->name,
                'number_phone' => $request->number_phone,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'with_delivery' => $request->with_delivery,
                'with_driver' => $request->with_driver,
                'address' => $request->address,
                'city' => $request->city,
                'booking_code' => $code,
                'user_id' => auth()->user()->id,
                'total_price' => $total_price_with_tax
            ]);
            return redirect()->route('front.payment', $booking->id);
        }
    }
}
