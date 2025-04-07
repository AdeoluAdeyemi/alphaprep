<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResponse extends Model
{
        use HasFactory;

    protected $fillable = [
        'id',
        'exam_session_id',
        'question_answer',
        'total_score',
        'question_count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'question_answer' => 'array',
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    // Define relationship with Parent Model.
    public function exam_session(): BelongsTo
    {
        return $this->belongsTo(ExamSession::class);
    }
}
