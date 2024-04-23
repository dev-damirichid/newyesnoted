<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Board;
use App\Models\Board_user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    function index() {
        $boardUser = Board_user::where('user_id', auth()->user()->id)->pluck('board_id');
        $board = Board::whereIn('id', $boardUser)->with('users')->get();  

        $data = (object) [
            'title' => 'Board',
            'board' => $board
        ];
        
        return view('board.index', compact('data'));
    }

    function create() {
        $user = [];
        $users = [];
        $query = User::all();
        foreach ($query as $key => $value) {
            if ($value->email != auth()->user()->email) {
                $user = (object) [
                    'id'    => $value->id,
                    'email'    => $value->email,
                ];
                array_push($users, $user);
            }
        }
        $data = (object) [
            'title' => 'Create Board',
            'users' => $users
        ];
        return view('board.create', compact('data'));
    }

    function store(Request $request) {
        $validated = $request->validate([
            'title'     => 'required|max:255',
            'member'    => 'nullable',            
        ]);

        $board = Board::create([
            'title'     => $request->title,
            'user_id'   => auth()->user()->id
        ]);

        if ($request->member) {
            foreach ($request->member as $key => $value) {
                Board_user::create([
                    'board_id'   => $board->id,
                    'user_id'    => $value
                ]);
            }
        }

        Board_user::create([
            'board_id'   => $board->id,
            'user_id'    => auth()->user()->id
        ]);

        toast('board have been created','success');
        return redirect()->route('board.index');
    }

    function storeUser(Request $request) {
        $board = Board::where('id', $request->slug)->first();
        if ($board->user_id != auth()->user()->id)  return abort(404);
        $validated = $request->validate([
            'slug'      => 'required',
            'member'    => 'required',            
        ]);

        foreach ($request->member as $key => $value) {
            Board_user::create([
                'board_id'   => $request->slug,
                'user_id'    => $value
            ]);
        }

        toast('user have been added','success');
        return redirect()->route('board.show.user', ['slug' =>   $board->slug]);
    }

    function userInvite($board) {
        $boardUser = Board_user::where('board_id', $board)
                            ->where('user_id', auth()->user()->id)
                            ->first();

        if (!$boardUser) {
            Board_user::create([
                'board_id'   => $board,
                'user_id'    => auth()->user()->id
            ]);
        }
        
        $boardd = Board::find($board);
        return redirect()->route('list-card.index', ['board' => $boardd->slug]);
    }

    function showUser($slug) {
        $board = Board::where('slug', $slug)->with('users')->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);

        $boardUser = Board_user::where('board_id', $board->id)->pluck('user_id');
        $user = [];
        $users = [];
        $query = User::all();
        foreach ($query as $key => $value) {
            if (! in_array($value->id, $boardUser->toArray())) {
                $user = (object) [
                    'id'        => $value->id,
                    'email'     => $value->email,
                ];
                array_push($users, $user);
            }
        }

        $data = (object) [
            'title'         => 'User Board',
            'board'         => $board,
            'users'         => $users
        ];

        return view('board.user', compact('data'));
    }

    function updateTitle(Request $request, $slug) {
        $board = Board::where('slug', $slug)->first();
        if ($board->user_id == auth()->user()->id) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors(),
                    'title' => $board->title
                ], 422);
            }

            $board->update([
                'title' => $request->title
            ]);
        } else {
            toast('something error','error');
        }
    }

    function destroy($slug) {
        $board = Board::where('slug', $slug)->first();
        if ($board->user_id == auth()->user()->id) {
            $board->delete();
            toast('board have been archived','success');
        } else {
            toast('board is not archived','error');
        }
        return redirect()->route('board.index');
    }

    function destroyUser($id) {
        $boardUser = Board_user::where('id', $id)->first();
        $board = Board::where('id', $boardUser->board_id)->first();
        if ($board->user_id == auth()->user()->id) {
            $boardUser->delete();
            toast('user have been deleted','success');
        } else {
            toast('board is not deleted','error');
        }
        return redirect()->route('board.show.user', ['slug' => $board->slug]);
    }
}
