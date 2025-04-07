<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, HasUuids, Sortable, SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'exam_id',
        'question_type',
        // 'option_type',
        // 'code_snippet',
        'position'
    ];
    public $sortable = [
        'exam_id',
        'type',
        'created_at',
        'updated_at'
    ];

    // Define relationship with Child Model
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    // Define relationship with Child Model
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
