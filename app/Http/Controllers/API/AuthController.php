<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use Auth;
use App\User;


class AuthController extends Controller
{

    public function register(Request $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }


    public function login()
    {
        $credentials = request()->only('email','password');
        $token = auth('api')->attempt($credentials);
    
        return $token;
    }
}


