<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;


class authController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request){
        $email = $request->email;
        $nama = $request->nama;
        $password = Hash::make($request->password);

        if(!$request->email){
            return response()->json([
                'success' => false,
                'message' => 'email belum dimasukan'
            ],400);
        }

        if(!$request->nama){
            return response()->json([
                'success' => false,
                'message' => 'nama belum dimasukan'
            ],400);
        }

        if(!$request->password){
            return response()->json([
                'success' => false,
                'message' => 'password belum dimasukan'
            ],400);
        }
        
        $user = user::create([
            'email' => $email,
            'nama' => $nama,
            'password' => $password
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully registered'
        ],200);
    }

    protected function jwt(user $user){
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $user->email,
            'iat' => time(),
            'exp' => time()+60*60
        ];

        return JWT::encode($payload, env('JWT_SECRET'),'HS256');
    }

    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;

        if(!$request->email){
            return response()->json([
                'success' => false,
                'message' => 'email belum dimasukan'
            ],400);
        }

        if(!$request->password){
            return response()->json([
                'success' => false,
                'message' => 'password belum dimasukan'
            ],400);
        }
        
        $user = user::where('email',$email)->first();

        if(!$user){
            return response()->json([
                'status' => 'Error',
                'message' => 'user not exist',
            ],404);
        }

        if(!Hash::check($password,$user->password)){
            return response()->json([
                'status' => 'Error',
                'message' => 'wrong password',
                ], 400);
        }

        $user->token = $this->jwt($user);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged in',
            'token' => $user->token
        ], 200);
    }
    //
}
