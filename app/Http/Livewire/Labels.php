<?php

namespace App\Http\Livewire;

use App\Models\Label;
use Livewire\Component;
use App\Models\Card_label;

class Labels extends Component
{
    public  $board_id, 
            $card_id, 
            $body = 'show', 
            $labels,
            $title,
            $labelCheckeds,
            $color;

    public function render()
    {
        return view('livewire.labels');
    }
    
    function mount() {
        $this->labels = Label::where('board_id', $this->board_id)->get();
        $this->labelCheckeds = Card_label::where('card_id', $this->card_id)->get();
    }

    function body($body) {
        $this->body = $body;
    }

    function store() {
        $validated = $this->validate([
            'title' => 'required',
            'color' => 'required',
        ]);
        Label::create([
            'board_id'  => $this->board_id,
            'label'     => $this->title,
            'color'     => $this->color,
        ]);
        $this->title = '';   
        $this->color = '';        
        $this->body = 'show';        
        $this->mount();
    }

    function cardLabel($id) {
        $check = Card_label::where('card_id', $this->card_id)->where('label_id', $id);
        if ($check->count()) {
            $check->first()->delete();
        } else {
            Card_label::create([
                'card_id'   => $this->card_id,
                'label_id'  => $id
            ]);
        }
    }
}
