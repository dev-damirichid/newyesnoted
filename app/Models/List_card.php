<?php

namespace App\Models;

use App\Models\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class List_card extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('number');
    }
}
