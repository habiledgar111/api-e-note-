<?php

namespace App\Http\Controllers;
use App\Models\mahasiswa;
use App\Models\prodi;
use Illuminate\Http\Request;

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
        $data = array();
        foreach (mahasiswa::all() as $mahasiswa) {
            // echo $mahasiswa->nim;
            // echo " ";
            $prodi = prodi::where('id',$mahasiswa->prodiId);
            $data['nim'] = $mahasiswa->nim;
            $data['nama'] = $mahasiswa->nama;
            $data['password'] = $mahasiswa->password;
            $data['angkatan'] = $mahasiswa->angkatan;
            $data['prodiId'] = $mahasiswa->prodiId;
            $data['prodi'] = $prodi;
        }
        // $data = mahasiswa::all();

        return response()->json([
            $data
        ]);
    }
    //
}
