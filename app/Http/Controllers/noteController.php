<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



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

    public function getAllNote(Request $request){
        $email = $request->user->email;
        $userwithnote = DB::table('notes')->where('user_id', '=', $email)->get();

        return response()->json([
            "success" => true,
            "message" => "grabbed all note",
            'user' => $userwithnote
            ],200);
    }
}
