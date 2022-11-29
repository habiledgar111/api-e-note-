<?php

namespace App\Http\Controllers;
use App\Models\mahasiswa;
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
        $nim = $request->nim;
        $nama = $request->nama;
        $angkatan = $request->angkatan;
        $password = $request->password;

        $mahasiswa = mahasiswa::create([
            'nim' => $nim,
            'nama' => $nama,
            'angkatan' => $angkatan,
            'password' => $password
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully registered'
        ],200);
    }

    protected function jwt(mahasiswa $mahasiswa){
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $mahasiswa->nim,
            'iat' => time(),
            'exp' => time()+60*60
        ];

        return JWT::encode($payload, env('JWT_SECRET'),'HS256');
    }

    public function login(Request $request){
        $nim = $request->nim;
        $password = $request->password;

        $mahasiswa = mahasiswa::where('nim',$nim)->first();

        if(!$mahasiswa){
            return response()->json([
                'status' => 'Error',
                'message' => 'user not exist',
                ], 404);
        }

        if($password != $mahasiswa->password){
            return response()->json([
                'status' => 'Error',
                'message' => 'wrong password',
                ], 400);
        }

        $mahasiswa->token = $this->jwt($mahasiswa);
        $mahasiswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged in',
            'token' => $mahasiswa->token
        ], 200);
    }
    //
}
