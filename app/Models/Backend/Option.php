<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'question_id',
        'options',
        'correct_answer',
        'explanation'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array'
    ];

    // Define relationship with Parent Model.
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
