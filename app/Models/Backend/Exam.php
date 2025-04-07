<?php

namespace App\Models\Backend;

use App\Models\Product;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description',
        'logo',
        'slug',
        'version',
        'timer',
        'year',
        'duration',
        'provider_id',
        'pass_mark'
    ];

    /**
     * Interact with the exam's slug.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value),
        );
    }
    // Define relationship with Parent Model.
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    // Define relationship with Child Model
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function toSearchableArray(): array
    {
        return [
            // 'id' => $this->id,
            'id'   => $this->getKey(),
            'description' => $this->description,
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
