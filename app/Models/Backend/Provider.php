<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
    'id',
    'name',
    'slug',
    'status',
    'featured',
    'description',
    'logo',
    'url',
    'category_id',
    ];

    /**
     * Get the exam provider's name.
     */
    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => strtolower($value),
    //     );
    // }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Define relationship with Child Model
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
