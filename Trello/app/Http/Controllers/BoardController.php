<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    // create
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        if (DB::select(
            "select COUNT(*) FROM boards WHERE name = ? AND user_id = ?",
            [$request->name, $user->id])) 
            return response()->json([
                'status' => 'failure',
                'message' => 'Board Already Exists',
                'user' => $user,
                'board_name' => $request->name,
            ]);

        DB::insert('insert into boards (name, user_id) values (?, ?)', [$request->name, $user->id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Board Creation Attempt Successful',
            'user' => $user,
            'board_name' => $request->name,
        ]);
    }
    // delete
    // get categories
    // get users
    // edit wallpaper
    // change name
}
