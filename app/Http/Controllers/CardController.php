<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\Board;
use App\Models\Log_card;
use App\Models\Card_user;
use App\Models\List_card;
use App\Models\Board_user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    function card($card) {
        $card = Card::find($card);
        $list_card = List_card::find($card->list_card_id);
        $board = Board::find($list_card->board_id)->slug;
        try {
            $board = Board::where('slug', $board)->first();
            if (!$board) abort(404);
            $board_user = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
            if (!$board_user) abort(404);

            $log = Log_card::orderBy('created_at', 'desc')->where('card_id', $card->id)->get();
    
            $data = (object) [
                'title' => 'Card '.$card->title,
                'board' => $board,
                'list_card' => $list_card,
                'card'  => $card,
                'log'   => $log,
            ];
            return view('board.list-card.card.index', compact('data'));            
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    function index($board, $list_card, $card) {
        try {
            $board = Board::where('slug', $board)->first();
            if (!$board) abort(404);
            $board_user = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
            if (!$board_user) abort(404);
            
            $card = Card::find($card);

            $log = Log_card::orderBy('created_at', 'desc')->where('card_id', $card->id)->get();
    
            $data = (object) [
                'title' => 'Card '.$card->title,
                'board' => $board,
                'list_card' => $list_card,
                'card'  => $card,
                'log'   => $log,
            ];
            return view('board.list-card.card.index', compact('data'));            
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    function user($board, $list_card, $card) {
        $board = Board::where('slug', $board)->with('users')->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);
        $card = Card::find($card);
        $cardUser = Card_user::where('card_id', $card->id)->pluck('user_id');
        $boardUser = Board_user::where('board_id', $board->id)->pluck('user_id');
        $user = [];
        $users = [];
        $query = User::all();
        foreach ($query as $key => $value) {
            if (in_array($value->id, $boardUser->toArray())) {
                if (! in_array($value->id, $cardUser->toArray())) {                
                    $user = (object) [
                        'id'        => $value->id,
                        'email'     => $value->email,
                    ];
                    array_push($users, $user);
                }
            }
        }

        $data = (object) [
            'title'         => 'User Card',
            'board'         => $board,
            'list_card'     => $list_card,
            'card'          => $card,
            'users'         => $users
        ];

        return view('board.list-card.card.user', compact('data')); 
    }

    function create($board, $list_card){
        $board = Board::where('slug', $board)->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);
        $listCard = List_card::find($list_card);

        $data = (object) [
            'title' => 'Create card  for '.$listCard->title,
            'board' => $board,
            'list_card' => $listCard,
        ];
        return view('board.list-card.card.create', compact('data'));
    }

    function store(Request $request, $board, $list_card) {
        $board = Board::where('slug', $board)->first();
        if (!$board) abort(404);
        $check = Board_user::where('board_id', $board->id)->where('user_id', auth()->user()->id)->count();
        if (!$check) abort(404);

        $validated = $request->validate([
            'title'         => 'required|max:255',
        ]);

        $getMaxLenght = Card::max('number');
        if (!$getMaxLenght) $getMaxLenght = 1;
        $getMaxLenght = $getMaxLenght+1;

        $getMaxLenght = Card::where('list_card_id', $list_card)->max('number');
        if (!$getMaxLenght) {
            $getMaxLenght = 1;
        } else {
            $getMaxLenght = $getMaxLenght+1;
        }

        $card = Card::create([
            'list_card_id'  => $list_card,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'title'         => $request->title,
            'number'        => $getMaxLenght,
            'description'   => $request->description,
        ]);

        Log_card::create([
            'card_id'   => $card->id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' create this card',
        ]);

        toast('Card have been created','success');
        return redirect()->route('list-card.index', ['board' => $board->slug]);
    }

    function storeUser(Request $request, $board, $list_card, $card) {
        $validated = $request->validate([
            'card'      => 'required',
            'member'    => 'required',            
        ]);

        $user = [];

        foreach ($request->member as $key => $value) {
            $cardd = Card_user::create([
                'card_id'   => $request->card,
                'user_id'    => $value
            ]);


            array_push($user, $cardd->user->name);
        }

        $text = 'member';
        if (count($user) > 1) {
            $text = 'members';
        }

        Log_card::create([
            'card_id'   => $card,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name." add $text `". implode(', ',$user) .'` in this card',
        ]);

        toast('user have been added','success');
        return redirect()->route('card.user', ['board' => $board, 'list_card' => $list_card, 'card' => $card]);
    }

    function destroyUser($board, $list_card, $card, $id) {
        $cardUser = Card_user::where('id', $id)->first();
        $cardUser->delete();
        Log_card::create([
            'card_id'   => $card,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name." remove member `". $cardUser->user->name .'` from this card',
        ]);
        toast('user have been deleted','success');
        return redirect()->route('card.user', ['board' => $board, 'list_card' => $list_card, 'card' => $card]);
    }

    function editDescription($board, $list_card, $card) {
        $card = Card::find($card);        
        $board = Board::where('slug', $board)->first();
        $data = (object) [
            'title'         => 'Edit description',
            'board'         => $board,
            'list_card'     => $list_card,
            'card'          => $card,
        ];
        return view('board.list-card.card.edit-description', compact('data'));
    }

    function editEstimate($board, $list_card, $card) {
        $card = Card::find($card);        
        $board = Board::where('slug', $board)->first();
        $data = (object) [
            'title'         => 'Edit estimate',
            'board'         => $board,
            'list_card'     => $list_card,
            'card'          => $card,
        ];
        return view('board.list-card.card.edit-estimate', compact('data'));
    }

    function updateDescription(Request $request, $board, $list_card, $card) {
        $validated = $request->validate([
            'description' => 'nullable'
        ]);
        $card = Card::find($card);
        $card->update($validated);
        Log_card::create([
            'card_id'   => $card->id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' change description on this card',
        ]);
        toast('description have been updated','success');
        return redirect()->route('card.index', ['board' => $board, 'list_card' => $list_card, 'card' => $card]);
    }

    function updateEstimate(Request $request, $board, $list_card, $card) {
        $validated = $request->validate([
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);
        $card = Card::find($card);
        $card->update($validated);
        Log_card::create([
            'card_id'   => $card->id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' change estimate on this card',
        ]);
        toast('Estimate have been updated','success');
        return redirect()->route('card.index', ['board' => $board, 'list_card' => $list_card, 'card' => $card]);
    }

    function updateTitle(Request $request, Card $card) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'title' => $card->title
            ], 422);
        }

        $card->update([
            'title' => $request->title
        ]);
    }

    function destroy(Request $request, Card $card) {
        $card->delete();
        $list_card = List_card::find($card->list_card_id);
        $board = Board::find($list_card->board_id);
        toast('card have been archived','success');
        return redirect()->route('list-card.index', ['board' => $board->slug]);
    }

    function numbering(Request $request) {
        $card = Card::orderBy('number', 'ASC')->get();
        $id = $request->input('id');
        $sorting = $request->input('sorting');
        foreach ($card as $item) {
            return Card::where('id', '=', $id)->update(['number' => $sorting]);
        }
    }
}
