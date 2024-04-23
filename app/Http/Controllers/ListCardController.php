<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\List_card;
use App\Models\Board_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ListCardController extends Controller
{
    function index($board) {
        $board = Board::where('slug', $board)->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);
        
        $listCard = List_Card::where('board_id', $board->id)->orderBy('number', 'asc')->get();

        $data = (object) [
            'title'         => $board->title,
            'board'         => $board,
            'list_card'     => $listCard
        ];
        return view('board.list-card.index', compact('data'));
    }

    function create($board) {
        $board = Board::where('slug', $board)->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);

        $data = (object) [
            'title' => 'Create list card for '.$board->title,
            'board' => $board
        ];
        return view('board.list-card.create', compact('data'));
    }

    function store(Request $request, $board) {
        $board = Board::where('slug', $board)->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);

        $validated = $request->validate([
            'title'     => 'required|max:255'
        ]);

        $getMaxLenght = List_card::max('number');
        if (!$getMaxLenght) $getMaxLenght = 1;
        $getMaxLenght = $getMaxLenght+1;

        $getMaxLenght = List_card::where('board_id', $board->id)->max('number');
        if (!$getMaxLenght) {
            $getMaxLenght = 1;
        } else {
            $getMaxLenght = $getMaxLenght+1;
        }

        List_card::create([
            'board_id'  => $board->id,
            'title'     => $request->title,
            'number'    => $getMaxLenght
        ]);

        toast('List card have been created','success');
        return redirect()->route('list-card.index', ['board' => $board->slug]);
    }

    function updateTitle(Request $request, $list_card) {
        $list_card = List_card::where('id', $list_card)->first();
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'title' => $list_card->title
            ], 422);
        }

        $list_card->update([
            'title' => $request->title
        ]);
    }

    function destroy($list_card) {
        $list_card = List_card::find($list_card);
        $board = Board::find($list_card->board_id);
        $list_card->delete();
        toast('list card have been archived','success');
        return redirect()->route('list-card.index', ['board' => $board->slug]);
    }

    function numbering(Request $request) {
        $list_card = List_card::orderBy('number', 'ASC')->get();
        $id = $request->input('id');
        $sorting = $request->input('sorting');
        foreach ($list_card as $item) {
            return List_card::where('id', '=', $id)->update(['number' => $sorting]);
        }
    }
}
