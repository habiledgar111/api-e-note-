<?php

namespace App\Http\Controllers;
use App\Models\mahasiswa;
use App\Models\prodi;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class mahasiswaController extends Controller
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

    //kendala disini
    public function getallmhs(){
        // $mahasiswa = mahasiswa::all();
        $mahasiswa = mahasiswa::with('prodi','mhstomk')->get();

        return response()->json([
            "success" => true,
            "message" => "grabbed all mahasiswa",
            'mahasiswa' => $mahasiswa
            ],200);
    }

    public function getmhs(Request $request){
        $nim = $request->nim;
        $mahasiswa = mahasiswa::find($nim);

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'prodi' => $mahasiswa->prodi
        ]);
    }

    public function getmhstoken(Request $request){

        return response()->json([
            'mahasiswa' => $request->mahasiswa
        ]);
    }
    //
}
