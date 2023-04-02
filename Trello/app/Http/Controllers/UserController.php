<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function get_boards(){
        $user = Auth::user();
        $boards = DB::table('boards')->where('user_id', $user->id)->pluck('name')->toArray();
        return response()->json([
            'status' => 'success',
            'message' => 'List of Boards',
            'user' => $user,
            'boards' => $boards,
        ]);
    }
}
