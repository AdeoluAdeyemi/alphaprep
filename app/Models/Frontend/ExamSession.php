<?php

namespace App\Models\Frontend;

use App\Models\Backend\Exam;
use App\Models\Backend\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ExamSession extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'exam_id',
        'user_id',
        'status',
        'mode',
        'completion_time',
        'incomplete_duration'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'question_answer' => 'array',
        'incomplete_duration' => 'array',
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    /**
     * Get the exam associated with the exam_session.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    // Define relation between Session and Response
    public function exam_response(): HasOne
    {
        return $this->hasOne(ExamResponse::class);
    }

    /**
     * Get the Questions.
     */
    // public function examQuestions(): HasOneThrough
    // {
    //     return $this->hasOneThrough(Question::class, Exam::class);
    // }

    public function questions()
    {
        return $this->exam->questions();
    }

    public function provider()
    {
        return $this->exam->provider();
    }
}

/**
 * Class Uuid.
 * Manages the usage of creating UUID values for primary keys. Drop into your models as
 * per normal to use this functionality. Works right out of the box.
 * Taken from: http://garrettstjohn.com/entry/using-uuids-laravel-eloquent-orm/
 */
trait UuidForKey
{

    /**
     * The "booting" method of the model.
     */
    public static function bootUuidForKey()
    {
        static::retrieved(function (Model $model) {
            $model->incrementing = false;  // this is used after instance is loaded from DB
        });

        static::creating(function (Model $model) {
            $model->incrementing = false; // this is used for new instances

            if (empty($model->{$model->getKeyName()})) { // if it's not empty, then we want to use a specific id
                $model->{$model->getKeyName()} = (string)Uuid::uuid4();
            }
        });
    }

    public function initializeUuidForKey()
    {
        $this->keyType = 'string';
    }
}
