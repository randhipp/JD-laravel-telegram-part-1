<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;

use Auth;
use Session;

class LoginController extends Controller
{

    protected $telegram;

    /**
     * Get user info and log in (hypothetically)
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function handleTelegramCallback()
    {
        if ($this->telegram->validate()) {
            $user = $this->telegram->user();

            $authUser = User::where('telegram_id',$user['id'])->first();

            if ($authUser){
                Auth::login($authUser, true);

                return redirect('/home');
            } else {
                Session::flush();
                Session::put('data', $user);
                Session::put('_from', 'telegram');
                return redirect('/register');
            }

        }


    }
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TelegramLoginAuth $telegram)
    {
        $this->telegram = $telegram;
        $this->middleware('guest')->except('logout');
    }
}
