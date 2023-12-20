<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\NoticeMailRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use App\Mail\NoticeMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(LoginRequest $request) {
        $user = $request->only(['email' , 'password']);

        if (Auth::attempt($user)) {
            $request->session()->regenerate();
            return redirect('/mypage');
        }

        return redirect('/login')->with('error', 'メールアドレスまたはパスワードが間違っています');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/login");
    }

    public function register()
    {
        return view('register');
    }

    public function storeRegistrant(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $role_user = RoleUser::create([
            'user_id' => $user->id,
            'role_id' => 3,
        ]);

        Auth::login($user);

        return redirect('/mypage');
    }

    public function notice(Request $request) {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('thanks');
    }

    public function send(Request $request) {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function verification(Request $request) {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    public function adminPage(Request $request) {
        $user = Auth::user();

        foreach( $user->roles as $role) {
            if($role->id != 1) {
                return redirect('/mypage');
            }
        }

        $users = User::all();

        switch($request->trigger) {
            case 0;
            return view('admin', compact('users'))->with(['send_notice' => false, 'import_csv' => false]);
            break;
            case 1;
            return view('admin', compact('users'))->with(['send_notice' => true, 'import_csv' => false]);
            break;
            case 2;
            return view('admin', compact('users'))->with(['send_notice' => false, 'import_csv' => true]);
            break;
        }
    }

    public function search(Request $request) {
        $users = User::where('name', 'like', '%' . $request->keyword . '%')->get();

        return view('admin', compact('users'))->with(['send_notice' => false, 'import_csv' => false]);
    }

    public function attach(Request $request) {
        $role = RoleUser::where('user_id', $request->user_id)->first();
        $role->update([
            'role_id' => $request->role_id
        ]);

        return back();
    }

    public function detach(Request $request) {
        $role = RoleUser::where('user_id', $request->user_id)->first();
        $role->update([
            'role_id' => 3
        ]);
        return back();
    }

    public function noticeMail(NoticeMailRequest $request) {
        $users = User::all();

        $contents = [
            'title' => $request->title,
            'body' => $request->body,
        ];

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NoticeMail($contents));
        }

        return redirect('/admin/0')->with('message', 'お知らせメールを送信しました');
    }
}
