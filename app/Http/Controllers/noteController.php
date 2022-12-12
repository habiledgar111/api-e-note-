<?php

namespace App\Http\Controllers;

use App\Models\note;
use Illuminate\Http\Request;



class noteController extends Controller
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

    //add note
    public function addnote(Request $request){
        $judul = $request->judul;
        $content = $request->content;
        $user = $request->user;

        $note = note::create([
            'judul' => $judul,
            'content' => $content,
            'user_id' => $user->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully add note'
        ],200);
    }
}
