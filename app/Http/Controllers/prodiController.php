<?php

namespace App\Http\Controllers;
use App\Models\prodi;
use Illuminate\Http\Request;
class prodiController extends Controller
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

    //get all prodi
    public function prodi(){
        $prodi = prodi::all();

        if(!$prodi){
            return response()->json([
                'success' => 'error',
                'message' => 'no data'
            ],500);
        }

        return response()->json([
        'prodi' => $prodi
        ],200);
    }
    //
}
