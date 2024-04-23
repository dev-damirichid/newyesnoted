<?php

namespace App\Models;

use App\Models\Label;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card_label extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
