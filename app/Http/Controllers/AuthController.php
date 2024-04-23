<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Email_verified_token;
use App\Models\Password_reset_token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    function login(Request $request) {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email'     => 'required|email',
                'password'  => 'required'
            ]);

            $remember = $request->remember ? true : false;

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                if (!auth()->user()->email_verified_at) {
                    $verif = Email_verified_token::where('email', $request->email)->first();
                    if (!$verif || $verif->expired_at <= Carbon::now()) {
                        Email_verified_token::where('email', $request->email)->delete();
                        $verify = Email_verified_token::create([
                            'email'         => $request->email,
                            'token'         => Str::random(50),
                            'expired_at'    => Carbon::now()->addMinutes(5)
                        ]);

                        $user = User::where('email', $request->email)->first();

                        $data = [
                            'subject'   => 'Verify email '.env('APP_NAME'),
                            'name'      => $user->name,
                            'text'      => 'This is your link to verify your email',
                            'url'       => route('verified-token', ['token' => $verify->token]),
                        ];
                        Mail::to($request->email)->send(new SendMail($data));
                    }
                }
                toast('Login is successful','success');
                return redirect()->route('dashboard.index');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
        $data = (object) [
            'title' => 'Login',
        ];
        return view('auth.login', compact('data'));
    }

    function verified(Request $request)
    {
        if ($request->isMethod('post')) {
            if (!auth()->user()->email_verified_at) {
                $verif = Email_verified_token::where('email', auth()->user()->email)->first();
                if (!$verif || $verif->expired_at <= Carbon::now()) {
                    Email_verified_token::where('email', auth()->user()->email)->delete();
                    $verify = Email_verified_token::create([
                        'email'         => auth()->user()->email,
                        'token'         => Str::random(50),
                        'expired_at'    => Carbon::now()->addMinutes(5)
                    ]);

                    $user = User::where('email', auth()->user()->email)->first();

                    $data = [
                        'subject'   => 'Verify email '.env('APP_NAME'),
                        'name'      => $user->name,
                        'text'      => 'This is your link to verify your email',
                        'url'       => route('verified-token', ['token' => $verify->token]),
                    ];
                    Mail::to(auth()->user()->email)->send(new SendMail($data));
                    alert()->success('New link was send to your email','please check your email!');
                } else {
                    $end_date = Carbon::parse($verif->expired_at);
                    $seconds = $end_date->diffInSeconds(Carbon::now());
                    alert()->info("wait for $seconds seconds for new link",'please wait!');
                }
            }
        }
        if (auth()->user()->email_verified_at) {
            return redirect()->route('dashboard.index');
        }
        $data = (object) [
            'title' => 'Email Verification',
        ];
        return view('auth.varified-email', compact('data'));
    }

    function verifiedToken(string $token)
    {
        $verified = Email_verified_token::where('token', $token)->first();
        if (!$verified) abort(404);
        $data = (object)[
            'title' => 'verified account '.$verified->email,
        ];
        User::where('email', $verified->email)->update([
            'email_verified_at' => Carbon::now()
        ]);
        Email_verified_token::where('token', $token)->delete();
        return view('auth.verified-email-success', compact('data'));
    }

    function register(Request $request) {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name'              => 'required|max:30',
                'email'             => 'required|email|unique:users,email',
                'password'          => 'required|confirmed',
                'trems_&_conditions' => 'required'
            ]);

            User::create($request->all());

            alert()->success('Registration is successful','please login!');

            return redirect()->route('login');
        }
        $data = (object) [
            'title' => 'Register',
        ];
        return view('auth.register', compact('data'));
    }

    function forgotPassword(Request $request) {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'email'             => 'required|email|exists:users,email'
            ]);
            $verif = Password_reset_token::where('email', $request->email)->first();
            if (!$verif || $verif->expired_at <= Carbon::now()) {
                Password_reset_token::where('email', $request->email)->delete();
                $reset = Password_reset_token::create([
                    'email'         => $request->email,
                    'token'         => Str::random(50),
                    'expired_at'    => Carbon::now()->addMinutes(5)
                ]);
                $user = User::where('email', $request->email)->first();
                $data = [
                    'subject'   => 'Reset password '.env('APP_NAME'),
                    'name'      => $user->name,
                    'text'      => 'This is your link to reset your password',
                    'url'       => route('reset-password', ['token' => $reset->token]),
                ];
                Mail::to($request->email)->send(new SendMail($data));
                alert()->success('Link to reset password was send','please check your email!');
            } else {
                alert()->success('Link to reset password was send','please wait 5 minute for new link!');
            }
            
            return redirect()->back();
        }
        $data = (object) [
            'title' => 'Forgot Password',
        ];
        return view('auth.forgot-password', compact('data'));
    }

    function resetPasswordToken(string $token, Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'password'     => 'required|confirmed',
            ]);

            $reset = Password_reset_token::where('token', $token)->first();
            if (!$reset) return response()->json(['message' => 'token not found'], 200);

            $user = User::where('email', $reset->email)->first();
            $user->update([
                'password'  => $request->password
            ]);

            Password_reset_token::where('token', $token)->delete();

            alert()->success('Reset password is successful','please login!');

            return redirect()->route('login');
        }

        $reset = Password_reset_token::where('token', $token)->first();
        if (!$reset) abort(404);
        $data = (object) [
            'title' => 'Reset Password to '.$reset->email,
            'token' => $token,
            'email' => $reset->email
        ];
        return view('auth.reset-password', compact('data'));
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        toast('Logout is successful','success');

        return redirect()->route('login');
    }
}
