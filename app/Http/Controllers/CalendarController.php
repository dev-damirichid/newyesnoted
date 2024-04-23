<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Checklist;
use App\Models\List_card;
use App\Models\Board_user;
use Illuminate\Http\Request;
use App\Models\ChecklistDetail;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    function index() {
        $userId = auth()->user()->id;
        $userBoards = Board_user::where('user_id', $userId)->pluck('board_id');
        $userListCards = List_card::whereIn('board_id', $userBoards)->pluck('id');
        $userCards = Card::whereIn('list_card_id', $userListCards)->pluck('id');
        $userChecklists = Checklist::whereIn('card_id', $userCards)->pluck('id');
        $userChecks = ChecklistDetail::whereIn('checklist_id', $userChecklists)->get();
        $calendar = [];

        $card = Card::whereIn('list_card_id', $userListCards)->get();

        foreach ($card as $key => $value) {
            array_push($calendar, (object) [
                'title' => $value['title'],
                'start' => $value['start_date'],
                'end'   => $value['end_date'],
                'url'   => route('card.show', ['card' => $value->id])
            ]);
        }

        foreach ($userChecks as $key => $value) {
            $checklisss = Checklist::find($value->checklist_id);
            // if ($value->check == 'uncheck') {
                array_push($calendar, (object) [
                    'title' => $value['title'],
                    'start' => $value['start_date'],
                    'end'   => $value['end_date'],
                    'url'   => route('card.show', ['card' => $checklisss->card_id])
                ]);
            // }
        }

        $data = (object) [
            'title'     => 'Calendar',
            'calendar'  => $calendar
        ];        
        return view('calendar.index', compact('data'));
    }
}
