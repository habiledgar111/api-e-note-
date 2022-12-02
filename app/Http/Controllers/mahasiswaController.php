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
        $mahasiswa = mahasiswa::with('prodi','matakuliah')->get();

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
            'prodi' => $mahasiswa->prodi, 
            'matakuliah' => $mahasiswa->matakuliah
        ]);
    }

    public function addmk(Request $request){
        $mahasiswa = mahasiswa::find($request->nim);
        
        $mahasiswa->matakuliah()->attach($request->id);

        return response()->json([
            "success" => true,
            "message" => "Mata kuliah added to mahasiswa"
        ]);
    }

    public function getmhstoken(Request $request){

        return response()->json([
            "success" => true,
            "message" => "grabbed mahasiswa by token",
            'mahasiswa' => $request->mahasiswa
        ]);
    }

    public function delete(Request $request){
        $mahasiswa = mahasiswa::find($request->nim);
        $mahasiswa ->matakuliah()->detach($request->id);
        return response()->json([
            "success" => true,
            "message" => "Mata kuliah deleted from mahasiswa"
        ]);
    }
    //
}
