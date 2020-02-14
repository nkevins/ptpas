<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function index()
    {
        return view('login');
    }
    
    /**
     * Handle login request 
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember');
        
        if (Auth::attempt(['username' => $username, 'password' => $password, 'active' => 1], $remember)) {
            return redirect()->action('DashboardController@index');
        } else {
            flash()->error('Invalid username / password')->important();
            return redirect()->route('login');
        }
    }
    
    protected function loggedOut(Request $request) {
        return redirect()->route('login');
    }
}
