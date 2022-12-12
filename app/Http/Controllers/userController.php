<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\user;
use App\Models\prodi;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class userController extends BaseController
{
    //

    public function getUserbyToken(Request $request){
        return response()->json([
            "success" => true,
            "message" => "grabbed user by token",
            "user" => $request->user
            // "user" => ["email" => $request->email,
            //             "nama" => $request->nama]
        ]);
    }
}
