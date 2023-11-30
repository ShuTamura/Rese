<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\PaymentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index']);
Route::get('/menu', [ShopController::class, 'menu']);
Route::get('/detail/{shop}', [ShopController::class, 'detail']);
Route::get('/search', [ShopController::class, 'search']);

Route::middleware(['web', 'verified', 'auth'])->group(function () {
    Route::get('/done', [ShopController::class, 'done']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::prefix('rep')->group(function () {
        Route::get('', [ShopController::class, 'repPage']);
        Route::get('shop', [ShopController::class, 'shopInfo']);
        Route::post('shop/add', [ShopController::class, 'addShop']);
        Route::patch('shop/update', [ShopController::class, 'updateShop']);
        Route::get('reservation/', [ReservationController::class, 'getReservation']);
        Route::get('reservation/search', [ReservationController::class, 'search']);
        Route::get('reservation/{reservation}', [ReservationController::class, 'reservationInfo']);
    });

    Route::prefix('admin')->group(function () {
        Route::get('{notice}', [AuthController::class, 'adminPage']);
        Route::post('send', [AuthController::class, 'noticeMail']);
        Route::get('{notice}/search', [AuthController::class, 'search']);
        Route::patch('attach', [AuthController::class, 'attach']);
        Route::patch('detach', [AuthController::class, 'detach']);
    });

    Route::prefix('mypage')->group(function () {
        Route::get('', [ShopController::class,'helloUser'])->name('mypage');
        Route::get('qr/{reservation_id}', [ReservationController::class,'getQrCode']);
        // Route::get('payment/', function() {
        //     return redirect()->route('mypage');
        // });
        Route::get('payment/{reservation_id}', [PaymentsController::class,'getPayment']);
        Route::post('payment/{reservation_id}', [PaymentsController::class,'Payment']);
        Route::get('visited', [ShopController::class,'visited']);
        Route::get('review/{review}', [ShopController::class,'reviewPage']);
        Route::patch('review/{review}', [ShopController::class,'review']);
    });

    Route::prefix('favorite')->group(function () {
        Route::post('add', [ShopController::class,'store']);
        Route::delete('delete', [ShopController::class,'destroy']);
    });

    Route::prefix('reservation')->group(function () {
        Route::post('add', [ReservationController::class,'store']);
        Route::patch('update', [ReservationController::class,'update']);
        Route::delete('delete', [ReservationController::class,'destroy']);
    });
});

Route::prefix('register')->name('verification.')->group (function() {
    Route::get('', [AuthController::class,'register']);
    Route::post('', [AuthController::class,'storeRegistrant']);
    Route::get('/verify', [AuthController::class, 'notice'])->name('notice');
    Route::post('/send', [AuthController::class, 'send'])
        ->middleware('throttle:6,1')->name('send');
    Route::get('/verification/{id}/{hash}', [AuthController::class, 'verification'])
        ->middleware(['signed', 'throttle:6,1'])->name('verify');
});

Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class,'login']);