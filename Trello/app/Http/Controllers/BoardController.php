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
        $result = DB::select(
            "select COUNT(*) AS count FROM boards WHERE name = ? AND user_id = ?",
            [$request->name, $user->id])[0]->count;
        
        // protect agains null user
        if ($result != 0) 
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
    public function delete(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $result = DB::select(
            "select COUNT(*) AS count FROM boards WHERE name = ? AND user_id = ?",
            [$request->name, $user->id])[0]->count;

        if ($result == 0) 
            return response()->json([
                'status' => 'failure',
                'message' => 'Board Already Does not Exists',
                'user' => $user,
                'board_name' => $request->name,
            ]);

        DB::delete('DELETE FROM boards WHERE name = ? AND user_id = ?', [$request->name, $user->id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Board Deletion Successful',
            'user' => $user,
            'board_name' => $request->name,
        ]);
    }
    // get categories
    public function get_categories(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $result = DB::select(
            "select COUNT(*) AS count FROM boards WHERE name = ? AND user_id = ?",
            [$request->name, $user->id])[0]->count;
        if ($result == 0) 
            return response()->json([
                'status' => 'failure',
                'message' => 'Board Does not Exists',
                'user' => $user,
                'board_name' => $request->name,
            ]);
        $board_id = DB::table('boards')->where('name', $request->name)->where('user_id', $user->id)->value('id');
        $result = DB::table('categories')->where('board_id', $board_id)->value('id', 'name');
        return response()->json([
            'status' => 'failure',
            'message' => 'Board Does not Exists',
            'user' => $user,
            'board_name' => $request->name,
            'board_id' => $board_id,
            'sql_result' => $result,
        ]);
    }
    // get users
    public function get_users(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $result = DB::select(
            "select COUNT(*) AS count FROM boards WHERE name = ? AND user_id = ?",
            [$request->name, $user->id])[0]->count;
        if ($result == 0) 
            return response()->json([
                'status' => 'failure',
                'message' => 'Board Does not Exists',
                'user' => $user,
                'board_name' => $request->name,
            ]);
        $board_id = DB::table('boards')->where('name', $request->name)->where('user_id', $user->id)->value('id');
        $result = DB::table('board_users')->where('board_id', $board_id)->pluck('user_id')->toArray();
        return response()->json([
            'status' => 'success',
            'message' => 'There are no collaborators for this board',
            'user' => $user,
            'board_name' => $request->name,
            'board_id' => $board_id,
            'sql_result' => $result,
        ]);
    }
    // add users
    public function add_user(Request $request){
        $request->validate([
            'board_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $collaborator_id = DB::select(
            "select COUNT(*) AS count FROM users WHERE name = ?",
            [$request->user_name])[0]->count;
        
        // protect agains null user
        if ($collaborator_id != 0) 
            return response()->json([
                'status' => 'failure',
                'message' => 'No such user exists',
                'user' => $user,
                'board_name' => $request->name,
            ]);

        $board_id = DB::select(
            "select COUNT(*) AS count FROM users WHERE name = ?",
            [$request->user_name])[0]->count;
        
        // protect agains null user
        if ($board_id != 0) 
            return response()->json([
                'status' => 'failure',
                'message' => 'No such board exists',
                'user' => $user,
                'board_name' => $request->name,
            ]);

        DB::insert('insert into board_users (board_id, user_id) values (?, ?)', [$board_id, $collaborator_id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Collaborator Addition Successful',
            'user' => $user,
            'board_name' => $request->name,
        ]);
    }

    // remove users
    // edit wallpaper
    // change name
}
