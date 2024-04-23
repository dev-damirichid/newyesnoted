<?php

namespace App\Models;

use App\Models\ChecklistDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(ChecklistDetail::class);
    }
}
