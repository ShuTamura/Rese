<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request) {
        $id = Auth::id();

        Reservation::create([
            'user_id' => $id,
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'payment' => 0,
        ]);

        return redirect('/done');
    }

    public function update(Request $request)
    {
        $reservation = $request->only(['date', 'time', 'number']);
        Reservation::find($request->id)->update($reservation);
        session(['id' => $request->id]);

        return redirect('/mypage')->with('message', '予約内容を変更しました');
    }

    public function destroy(Request $request) {
        $id = Auth::id();

        Reservation::where('user_id', $id)->where('shop_id', $request->shop_id)->delete();

        return back();
    }

    public function getReservation() {
        $user = Auth::user();

        foreach( $user->roles as $role) {
            if($role->id != 2) {
                return redirect('/mypage');
            }
        }
        $shop = Shop::with('reservations')->where('user_id', $user->id)->first();
        $reservations = Reservation::where('shop_id', $shop->id)->get();

        return view('reservation', compact('reservations'));
    }

    public function search(Request $request) {
        $user = Auth::user();
        $shop = Shop::with('reservations')->where('user_id', $user->id)->first();

        if($request->date) {
            $reservations = Reservation::where('shop_id', $shop->id)
            ->whereHas('user', function ($q) use ($request){
                $q->where('name', 'like', '%' . $request->keyword . '%');
            })->whereDate('date', $request->date)->get();
        }else {
            $reservations = Reservation::where('shop_id', $shop->id)
            ->whereHas('user', function ($q) use ($request){
                $q->where('name', 'like', '%' . $request->keyword . '%');
            })->get();
        }

        return view('reservation', compact('reservations'));
    }

    public function reservationInfo(Reservation $reservation) {
        return view('verification', compact('reservation'));
    }

    public function getQrCode(Request $request) {
        $reservation = Reservation::find($request->reservation_id);
        return view('qr', compact('reservation'));
    }
}
