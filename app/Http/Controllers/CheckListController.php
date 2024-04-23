<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Board;
use App\Models\Log_card;
use App\Models\Checklist;
use App\Models\List_card;
use Illuminate\Http\Request;
use App\Models\ChecklistDetail;
use App\Http\Controllers\Controller;

class CheckListController extends Controller
{
    function create($board, $list_card, $card) {
        $card = Card::find($card);        
        $board = Board::where('slug', $board)->first();
        $data = (object) [
            'title'         => 'Create Checklist',
            'board'         => $board,
            'list_card'     => $list_card,
            'card'          => $card,
        ];
        return view('board.list-card.card.checklist.create', compact('data'));
    }

    function store(Request $request, $board, $list_card, $card) {
        $validated = $request->validate([
            'title'     => 'required|max:255'
        ]);

        $checklist = Checklist::create([
            'card_id'   => $card,
            'title'     => $request->title,
            'percentage'=> 0
        ]);

        $cardd = Card::find($card);

        Log_card::create([
            'card_id'   => $card,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' create checklist `'.$checklist->title.'` on this card',
        ]);

        toast('checklist have been created','success');
        return redirect()->route('card.index', ['board' => $board, 'list_card' => $list_card, 'card' => $card]);
    }

    function delete(Checklist $checklist){
        $checklist->delete();
        ChecklistDetail::where('checklist_id', $checklist->id)->delete();
        $card = Card::find($checklist->card_id);
        $list_card = List_card::find($card->list_card_id);
        $board = Board::find($list_card->board_id);
        Log_card::create([
            'card_id'   => $card->id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' delete checklist `'.$checklist->title.'` on this card',
        ]);
        toast('checklist have been deleted','success');
        return redirect()->route('card.index', ['board' => $board->slug, 'list_card' => $list_card->id, 'card' => $card->id]);
    }
}
