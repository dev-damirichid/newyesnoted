<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\Board;
use App\Models\Log_card;
use App\Models\Card_user;
use App\Models\Checklist;
use App\Models\List_card;
use App\Models\Board_user;
use Illuminate\Http\Request;
use App\Models\ChecklistDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChecklistDetailController extends Controller
{
    function index(Checklist $checklist) {
        $card = Card::find($checklist->card_id);        
        $list_card = List_card::find($card->list_card_id);       
        $board = Board::find($list_card->board_id);
        $data = (object) [
            'title'         => 'Edit Checklist',
            'board'         => $board,
            'list_card'     => $list_card,
            'card'          => $card,
            'checklist'     => $checklist
        ];
        return view('board.list-card.card.checklist.checklist-detail.index', compact('data'));
    }

    function create(Checklist $checklist) {
        $card = Card::find($checklist->card_id);        
        $list_card = List_card::find($card->list_card_id);       
        $board = Board::find($list_card->board_id);
        $cardUser = Card_user::where('card_id', $card->id)->pluck('user_id');
        $boardUser = Board_user::where('board_id', $board->id)->pluck('user_id');
        $user = [];
        $users = [];
        $query = User::all();
        foreach ($query as $key => $value) {
            if (in_array($value->id, $cardUser->toArray())) {                
                $user = (object) [
                    'id'        => $value->id,
                    'email'     => $value->email,
                ];
                array_push($users, $user);
            }
        }
        $data = (object) [
            'title'         => 'Create Checklist',
            'board'         => $board,
            'list_card'     => $list_card,
            'card'          => $card,
            'checklist'     => $checklist,
            'users'          => $users
        ];
        return view('board.list-card.card.checklist.checklist-detail.create', compact('data'));
    }

    function edit(Checklist $checklist, checklistDetail $checklist_detail) {
        $card = Card::find($checklist->card_id);        
        $list_card = List_card::find($card->list_card_id);       
        $board = Board::find($list_card->board_id);
        $cardUser = Card_user::where('card_id', $card->id)->pluck('user_id');
        $boardUser = Board_user::where('board_id', $board->id)->pluck('user_id');
        $user = [];
        $users = [];
        $query = User::all();
        foreach ($query as $key => $value) {
            if (in_array($value->id, $cardUser->toArray())) {                
                $user = (object) [
                    'id'        => $value->id,
                    'email'     => $value->email,
                ];
                array_push($users, $user);
            }
        }
        $data = (object) [
            'title'                 => 'Edit Checklist',
            'board'                 => $board,
            'list_card'             => $list_card,
            'card'                  => $card,
            'checklist'             => $checklist,
            'checklist_detail'      => $checklist_detail,
            'users'                 => $users
        ];
        return view('board.list-card.card.checklist.checklist-detail.edit', compact('data'));
    }

    function update(Request $request, Checklist $checklist, checklistDetail $checklist_detail) {
        $validated = $request->validate([
            'title'     => 'required|max:255'
        ]);

        $checklist_detail->update([
            'user_id'       => $request->pic,
            'checklist_id'  => $checklist->id,
            'title'         => $request->title,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
        ]);

        $detailsCountChecked = ChecklistDetail::where('checklist_id', $checklist->id)->where('check', 'checked')->count();
        $detailsCount = ChecklistDetail::where('checklist_id', $checklist->id)->count();
        $checklist = Checklist::find($checklist->id);
        $percentage = ($detailsCountChecked/$detailsCount)*100;
        $checklist->update([
            'percentage'    => $percentage
        ]);

        $card = Card::find($checklist->card_id);
        Log_card::create([
            'card_id'   => $card->id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' update `'.$checklist_detail->title.'` on checklist `'.$checklist->title.'`'
        ]);
        toast('detail checklist have been updated','success');
        return redirect()->route('checklist-detail.index', ['checklist' => $checklist->id]);
    }

    function store(Request $request, Checklist $checklist) {
        $validated = $request->validate([
            'title'     => 'required|max:255'
        ]);

        $detail = ChecklistDetail::create([
            'user_id'       => $request->pic,
            'checklist_id'  => $checklist->id,
            'title'         => $request->title,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
        ]);

        $detailsCountChecked = ChecklistDetail::where('checklist_id', $checklist->id)->where('check', 'checked')->count();
        $detailsCount = ChecklistDetail::where('checklist_id', $checklist->id)->count();
        $checklist = Checklist::find($checklist->id);
        $percentage = ($detailsCountChecked/$detailsCount)*100;
        $checklist->update([
            'percentage'    => $percentage
        ]);

        $card = Card::find($checklist->card_id);
        Log_card::create([
            'card_id'   => $card->id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' create `'.$detail->title.'` on checklist `'.$checklist->title.'`'
        ]);
        toast('detail checklist have been created','success');
        return redirect()->route('checklist-detail.index', ['checklist' => $checklist->id]);
    }

    function destroy(ChecklistDetail $checklist_detail) {
        $checklist_detail->delete();        
        $checklist = Checklist::find($checklist_detail->checklist_id);
        toast('detail checklist have been deleted','success');
        return redirect()->route('checklist-detail.index', ['checklist' => $checklist->id]);
    }

    function status(Request $request, ChecklistDetail $checklist_detail) {
        $validated = $request->validate([
            'check'     => 'required'
        ]);

        $checklist_detail->update([
            'check' => $request->check
        ]);


        $detailsCountChecked = ChecklistDetail::where('checklist_id', $checklist_detail->checklist_id)->where('check', 'checked')->count();
        $detailsCount = ChecklistDetail::where('checklist_id', $checklist_detail->checklist_id)->count();
        $checklist = Checklist::find($checklist_detail->checklist_id);
        $percentage = ($detailsCountChecked/$detailsCount)*100;
        $checklist->update([
            'percentage'    => $percentage
        ]);

        Log_card::create([
            'card_id'   => $checklist->card_id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' '.$request->check.' `'.$checklist_detail->title.'`'
        ]);
        
        toast('detail checklist have been update','success');
        return redirect()->route('checklist-detail.index', ['checklist' => $checklist_detail->checklist_id]);
    }

    function updateTitle(Request $request, Checklist $checklist) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'title' => $checklist->title
            ], 422);
        }

        $checklist->update([
            'title' => $request->title
        ]);
    }

    function updateCheckTitle(Request $request, ChecklistDetail $checklist_detail) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'title' =>  $checklist_detail->title
            ], 422);
        }

        $checklist_detail->update([
            'title' => $request->title
        ]);
    }

    function updateCheck(Request $request, ChecklistDetail $checklist_detail) {
        $checklist_detail->update([
            'check' => $request->check
        ]);
        $checklist = Checklist::find($checklist_detail->checklist_id);

        $detailsCountChecked = ChecklistDetail::where('checklist_id', $checklist_detail->checklist_id)->where('check', 'checked')->count();
        $detailsCount = ChecklistDetail::where('checklist_id', $checklist_detail->checklist_id)->count();
        $checklist = Checklist::find($checklist_detail->checklist_id);
        $percentage = ($detailsCountChecked/$detailsCount)*100;
        $checklist->update([
            'percentage'    => $percentage
        ]);
        
        Log_card::create([
            'card_id'   => $checklist->card_id,
            'user_id'   => auth()->user()->id,
            'subject'   => auth()->user()->name.' '.$request->check.' `'.$checklist_detail->title.'`'
        ]);
    }
}
