<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Board_user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function index() {        
        $userBoards = Board_user::where('user_id', auth()->user()->id)->pluck('board_id');
        $boards = Board::whereIn('id', $userBoards)->with(['users', 'listCard'])->get();
        $data = (object) [
            'title' => 'Dashboard',
            'boards' => $boards,

        ];
        return view('dashboard.index', compact('data'));
    }
}
