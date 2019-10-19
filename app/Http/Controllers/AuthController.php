<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return response()->json([
            	// 'code' => 200,
            ], 200);
        }
    	dd('xiflóide');
        return response()->json([
        	'message' => "Efetue o Login para continuar",
        	// 'code' => 401,
        ],401);
    }

}