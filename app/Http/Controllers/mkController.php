<?php

namespace App\Http\Controllers;
use App\Models\matakuliah;
use Illuminate\Http\Request;

class mkController extends Controller
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

    public function getallmk(){
        $mk = matakuliah::all();

        return response()->json([
            "success" => true,
            "message" => "grabbed all matakuliah",
            'matakuliah' => $mk
            ],200);
    }

    //
}
