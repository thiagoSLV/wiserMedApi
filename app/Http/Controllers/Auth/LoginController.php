<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Auth;

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
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:doctor')->except('logout');
        $this->middleware('guest:pacient')->except('logout');
    }

    public function doctorLogin(Request $request) {
        if (Auth::guard('pacient')->attempt(array('name' => $request->email, 'password' => $request->password)))
        {
            return response()->json([
                'message' => "Login efetuado",
            ], 200);
        }
        return response()->json([
            'message' => "Usuário e/ou senha inválidos",
        ], 401);
    }

    public function pacientLogin(Request $request) {
        if (Auth::guard('pacient')->attempt(array('name' => $request->email, 'password' => $request->password)))
        {
            return response()->json([
                'message' => "Login efetuado",
                'code' => 200,
            ], 200);
        }
        return response()->json([
            'message' => "Usuário e/ou senha inválidos",
            'code' => 401,
        ], 401);
    }
}
