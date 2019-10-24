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
     * Request Response.
     *
     * @var array
     */
    // protected $redirectTo = '/home';
       protected $response = [];

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
        if (Auth::guard('doctor')->attempt(array('email' => $request->email, 'password' => $request->password)))
        {
            $data = \App\Repositories\DoctorRepositoryEloquent::getByEmail($request->email)->all();
            dd(\App\Repositories\DoctorRepositoryEloquent::getByEmail($request->email)->all());
            array_push($this->response, ['message' => "Login efetuado", 'data' => $data]);
            return $this->response;
        }

        return response()->json([
            'message' => "Usuário e/ou senha inválidos",
        ], 401);
    }

    public function pacientLogin(Request $request) {
        if (Auth::guard('pacient')->attempt(array('email' => $request->email, 'password' => $request->password)))
        {
            $data = \App\Repositories\PacientRepositoryEloquent::getByEmail($request->email)->all();
            array_push($this->response, ['message' => "Login efetuado", 'data' => $data]);
            return $this->response;
        }
        return response()->json([
            'message' => "Usuário e/ou senha inválidos",
        ], 401);
    }
}
