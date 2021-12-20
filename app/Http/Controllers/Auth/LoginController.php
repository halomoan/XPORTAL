<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $maxAttempts = 5; // Default is 5
    protected $decayMinutes = 1; // Default is 1

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {

        $this->validateLogin($request);

        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Retrive Input
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // if success login
            $user = Auth::user();

            if ($user->hasRole("Admin")) {

                return redirect()
                    ->route('manage')
                    ->with('status','You are Logged in as Admin!');
            } else {

                return redirect()
                        ->route('home')
                        ->with('status','You are Logged in as User!');
            }
        }

         //keep track of login attempts from the user.
         $this->incrementLoginAttempts($request);
        //Authentication failed
        //return redirect('/login');
         return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                'password' => 'Wrong password or this account not approved yet.',
            ]);

    }
}
