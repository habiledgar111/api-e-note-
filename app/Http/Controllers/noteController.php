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
        
        if(!$request->judul){
            return response()->json([
                'success' => false,
                'message' => 'judul belum dimasukan'
            ],400);
        }

        if(!$request->content){
            $content = "";
        }
        
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

   public function deleteNote(Request $request){
        $user = $request->user;
        $note = DB::table('notes')->where([
            ['id', '=', $request->id],
            ['user_id', '=', $request->user->email]
        ])->delete();
        return response()->json([
            "success" => true,
            "message" => "note deleted from user"
        ],200);
    }

    public function updateNote(Request $request){
        $user = $request->user;
        $new_note = DB::table('notes')->where([
            ['id', '=', $request->id],
            ['user_id', '=', $request->user->email]
        ])->update([
            'judul' => $request->judul,
            'content' =>$request->content
            ]);
        return response()->json([
            "success" => true,
            "message" => "note updated from user"
        ],200);
    }
}
