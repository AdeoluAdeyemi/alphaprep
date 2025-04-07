<?php

namespace App\Models;

use App\Models\Backend\Exam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public $timestamps = true;

    public function exams()
    {
        return $this->belongsTo(Exam::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
