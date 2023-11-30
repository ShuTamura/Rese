<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class PaymentsController extends Controller
{
    public function getPayment() {
        $user = Auth::user();
        return view('payment', compact('user'));
    }
    public function payment(Request $request)
    {
        try
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 500,
                'currency' => 'jpy'
            ));

            $reservation = Reservation::find($request->reservation_id);

            $reservation -> update([
                'payment' => 1,
            ]);

            return redirect()->route('mypage');

        }catch(Exception $e) {
            return $e->getMessage();
        }
    }
}
