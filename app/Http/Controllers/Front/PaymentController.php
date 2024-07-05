<?php

namespace App\Http\Controllers\Front;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request, $bookingId)
    {
        $booking = Booking::with(['item.brand', 'item.type'])->where('user_id', Auth::id())->findOrFail($bookingId);
        $driver_price = 90000;

        return view('payment', [
            'booking' => $booking,
            'driver_price' => $driver_price
        ]);
    }

    public function detail(Request $request, $bookingId)
    {
        $booking = Booking::with(['item.brand', 'item.type'])->findOrFail($bookingId);

        return view('payment-detail', [
            'booking' => $booking
        ]);
    }

    public function update(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->payment_method = 'midtrans';

        // if ($request->payment_method == 'midtrans') {
        if ($booking->payment_method == 'midtrans') {
            // Call Midtrans API
            Config::$serverKey = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

            // Get USD to IDR rate using guzzle
            // $client = new \GuzzleHttp\Client();
            // $response = $client->request('GET', 'https://api.exchangerate-api.com/v4/latest/USD');
            // $body = $response->getBody();
            // $rate = json_decode($body)->rates->IDR;

            // Convert to IDR
            // $totalPrice = $booking->total_price * $rate;
            $totalPrice = $booking->total_price;

            // Create Midtrans Params
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $booking->booking_code,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $booking->customer_name,
                    'email' => $booking->customer_email,
                ],
                'enabled_payments' => ['gopay', 'bank_transfer', 'shopeepay', 'cstore'],
                'vtweb' => []
            ];



            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtransParams)->redirect_url;

            // Save payment URL to booking
            $booking->payment_url = $paymentUrl;
            $booking->save();

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }

        return redirect()->route('front.index');
    }

    public function success()
    {
        return view('success');
    }
}
