<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\CsvRequest;
use App\Http\Requests\CsvContentRequest;
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
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(Request $request) {
        $shops = Shop::with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('shops', 'areas', 'genres'));
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

    public function sort(Request $request) {
        if($request->sort == 'random') {
            $shops = Shop::with('area', 'genre')->inRandomOrder()->get();
        }elseif($request->sort == 'hight_score') {
            $shops = Shop::with('area', 'genre')->orderBy('all_score', 'desc')->get();
        }elseif($request->sort == 'low_score') {
            $shops = Shop::with('area', 'genre')->orderByRaw('all_score is null asc')->orderBy('all_score', 'asc')->get();
        }
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function menu() {
        $user = Auth::user();
        return view('menu', compact('user'));
    }

    public function detail(Shop $shop) {
        $user_id = Auth::id();

        $review = Review::where('user_id', $user_id)->where('shop_id', $shop->id)->first();
        return view('detail', compact('shop', 'review'));
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

    // public function reviewPage(Review $review) {
    //     $user_id = Auth::id();
    //     $review = Review::with('user', 'shop')->find($review->id);
    //     if( $user_id == $review->user->id ) {
    //         return view('review', compact('review'));
    //     }
    //     return back();
    // }

    // public function review(Request $request) {
    //     $review = $request->only(['score', 'comment']);
    //     Review::find($request->id)->update($review);

    //     return redirect('/mypage/visited');
    // }

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

    public function reviews(Shop $shop) {
        $user_id = Auth::id();
        $role_user = RoleUser::where('user_id', $user_id)->first();
        $reviews = Review::with('user', 'shop')->where('shop_id' ,$shop->id)->get();
        $count = $reviews->count();
        if( $role_user->role_id == 1 ) {
            return view('all_reviews', compact('reviews', 'shop'))->with(['is_admin'=>true,'count'=>$count]);
        }
        return view('all_reviews', compact('reviews', 'shop'))->with(['count'=>$count]);
    }

    public function createReview(Request $request) {
        $user_id = Auth::id();
        $shop_id = $request->shop_id;
        $count = Review::where('shop_id' ,$shop_id)->where('user_id', $user_id)->count();
        if($count == 0) {
            $review = Review::create([
                'user_id' => $user_id,
                'shop_id' => $shop_id,
            ]);
            return view('edit_review', compact('review', 'shop_id'));
        }
        return redirect('review/shop/' . $shop_id);
    }

    public function editReview(Shop $shop) {
        $user_id = Auth::id();
        $shop_id = $shop->id;
        $review = Review::where('shop_id' ,$shop->id)->where('user_id', $user_id)->first();
        return view('edit_review', compact('review', 'shop_id'));
    }

    public function updateReview(ReviewRequest $request, Review $review) {
        $review = Review::find($review->id);
        $sum = 0;
        if($request->file('image')) {
            $image_path = $request->file('image')->store('public/review_img/');
            $review -> update([
                'title' => $request->title,
                'score' => $request->score,
                'comment'=> $request->comment,
                'image' => basename($image_path),
            ]);
        }else {
            $review -> update([
                'title' => $request->title,
                'score' => $request->score,
                'comment'=> $request->comment,
            ]);
        }
        $all_reviews = Review::where('shop_id', $review->shop->id)->get();
        foreach($all_reviews as $all_review) {
            $sum = $sum + $all_review->score;
        }
        $all_score = $sum / $all_reviews->count();
        $shop = Shop::find($review->shop->id);
        $shop->update([
            'all_score' => $all_score,
        ]);
        return back()->withInput()->with('message', '口コミが更新されました');
    }

    public function destroyReview(Review $review) {
        Review::find($review->id)->delete();
        return back();
    }

    public function csvUpload(CsvRequest $request) {
        $csv_file = $request->file('csv_file');
        $csv_filename = $request->file('csv_file')->getClientOriginalName();
        $csv_path = $request->file('csv_file')->storeAs('public/csv', $csv_filename);

        $load = (new FastExcel)->configureCsv(',')->importSheets('storage/csv/'.$csv_filename);

        $count = 0;
        foreach($load as $row) {
            foreach($row as $item) {
                $params[$count] = [
                    'name' => $item["name"],
                    'area' => $item["area"],
                    'genre' => $item["genre"],
                    'detail' => $item["detail"],
                    'image' => $item["image"],
                ];
                $area = Area::where('name', $params[$count]['area'])->first();
                $genre = Genre::where('name', $params[$count]['genre'])->first();
                $image = file_get_contents($params[$count]['image']);
                $exploded_image_path = explode('/', $params[$count]['image']);
                $image_path = end($exploded_image_path);

                Storage::disk('public')->put('storage/shop_img/'.$image_path , $image);
                $count++;
            }
        }
        return view('csv_content', compact('params'));
    }

    public function csvAddPage() {

    }

    public function csvAdd(CsvContentRequest $request) {
        $count = count($request->name);
        for( $i=0; $i<$count; $i++) {
            $area = Area::where('name', $request->area[$i])->first();
            $genre = Genre::where('name', $request->genre[$i])->first();
            if( empty($area->name) && empty($genre->name) ) {
                return redirect('/admin/0')->with('error', '地域は「東京都」「大阪府」「福岡県」、ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」からお選びください');
            }elseif( empty($genre->name) ) {
                return redirect('/admin/0')->with('error', 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかです');
            }elseif( empty($area->name) ) {
                return redirect('/admin/0')->with('error', '地域は「東京都」「大阪府」「福岡県」のいずれかです');
            }
            $image = file_get_contents($request->image[$i]);
            $exploded_image_path = explode('/', $request->image[$i]);
            $image_path = end($exploded_image_path);

            $exploded_extension = explode('.', $image_path);
            $extension = end($exploded_extension);
            if($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png') {
                return redirect('/admin/0')->with('error', '拡張子はjpeg、jpg、pngです');
            }

            Storage::disk('public')->put('storage/shop_img/'.$image_path , $image);
            Shop::create([
                'name' => $request->name[$i],
                'area_id' => $area->id,
                'genre_id' => $genre->id,
                'detail' => $request->detail[$i],
                'image' => $image_path,
            ]);
        }
        return redirect('/admin/0')->with('message', '店舗情報を追加しました');
    }
}
