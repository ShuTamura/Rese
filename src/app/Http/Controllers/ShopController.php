<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use App\Models\RoleUser;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index(Request $request) {
        $shops = Shop::with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();

        $user_id = Auth::id();
        $favorites = Favorite::all();
        return view('index', compact('shops', 'areas', 'genres', 'favorites'));
    }

    public function search(Request $request) {
        $shops = Shop::with('area', 'genre')
        ->KeywordSearch($request->keyword)
        ->AreaSearch($request->area_id)
        ->GenreSearch($request->genre_id)
        ->get();

        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function menu() {
        $user = Auth::user();
        return view('menu', compact('user'));
    }

    public function detail(Shop $shop) {
        $shop = [
            'detail' => $shop
        ];
        return view('detail', $shop);
    }

    public function done() {
        return view('done');
    }

    public function helloUser() {
        if(Auth::user()) {
            $user = Auth::user();
            $dt = new Carbon();
            $date = $dt->toDateString();
            $time = $dt->toTimeString();

            $reservations = Reservation::where('user_id', $user->id)->get();
            foreach( $reservations as $reservation ) {
                $user_id = $reservation->user_id;
                $shop_id = $reservation->shop_id;
                $visited = Review::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
                if( $reservation->date < $date || ($reservation->date == $date && $reservation->time <= $time)) {
                    if( empty($visited) ) {
                        Review::create([
                        'user_id' => $user_id,
                        'shop_id' => $shop_id,
                        ]);
                    }
                    Reservation::find($reservation->id)->delete();
                }
            }
            return view('mypage', compact('user'));
        }
        return redirect('/login');
    }

    public function store(Request $request) {
        $id = Auth::id();

        Favorite::create([
            'user_id' => $id,
            'shop_id' => $request->shop_id,
        ]);

        return redirect('/');
    }

    public function destroy(Request $request) {
        $id = Auth::id();

        Favorite::where('user_id', $id)->where('shop_id', $request->shop_id)->delete();

        return back();
    }

    public function visited() {
        $id = Auth::id();

        $reviews = Review::with('user', 'shop')->where('user_id', $id)->get();

        return view('visited', compact('reviews'));
    }

    public function reviewPage(Review $review) {
        $review = Review::with('user', 'shop')->find($review->id);
        return view('review', compact('review'));
    }

    public function review(Request $request) {
        $review = $request->only(['score', 'comment']);
        Review::find($request->id)->update($review);

        return redirect('/mypage/visited');
    }

    public function repPage() {
        $user = Auth::user();

        foreach( $user->roles as $role) {
            if($role->id != 2) {
                return redirect('/mypage');
            }
        }
        $shop = Shop::with('user')->where('user_id', $user->id)->first();

        return view('rep', compact('user', 'shop'));
    }

    public function shopInfo() {
        $user = Auth::user();

        foreach( $user->roles as $role) {
            if($role->id != 2) {
                return redirect('/mypage');
            }
        }
        $shop = Shop::with('area', 'genre', 'user')->where('user_id', $user->id)->first();
        $areas = Area::all();
        $genres = Genre::all();

        return view('shop_info', compact('user', 'shop', 'areas', 'genres'));
    }

    public function addShop(ShopRequest $request) {
        $user = Auth::user();

        foreach( $user->roles as $role) {
            if($role->id != 2) {
                return redirect('/mypage');
            }
        }

        if($request->file('image')) {
            $image_path = $request->file('image')->store('public/shop_img/');
            Shop::create([
                'name' => $request->name,
                'area_id' => $request->area_id,
                'genre_id' => $request->genre_id,
                'user_id' => $request->user_id,
                'detail' => $request->detail,
                'image' => basename($image_path),
            ]);
        }else {
            Shop::create([
                'name' => $request->name,
                'area_id' => $request->area_id,
                'genre_id' => $request->genre_id,
                'user_id' => $request->user_id,
                'detail' => $request->detail,
                'image' => 'non-image.png',
            ]);
        }
        return redirect('/rep/shop')->with('message', '店舗情報を登録しました');
    }

    public function updateShop(ShopRequest $request) {
        $user = Auth::user();

        $shop = Shop::find($request->id);

        if($request->file('image')) {
            $image_path = $request->file('image')->store('public/shop_img/');
            $shop -> update([
                'name' => $request->name,
                'area_id' => $request->area_id,
                'genre_id' => $request->genre_id,
                'detail' => $request->detail,
                'image' => basename($image_path),
            ]);
        }else {
            $shop -> update([
                'name' => $request->name,
                'area_id' => $request->area_id,
                'genre_id' => $request->genre_id,
                'detail' => $request->detail,
                'image' => 'non-image.png',
            ]);
        }

        return redirect('/rep/shop')->with('message', '店舗情報を更新しました');
    }
}
