<?php

namespace App\Models;

use App\Models\Card_user;
use App\Models\Checklist;
use App\Models\Card_label;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(Card_user::class);
    }

    public function card_labels()
    {
        return $this->hasMany(Card_label::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
}
