<?php

namespace App\Models\Frontend;

use App\Models\Product;
use Laravel\Scout\Searchable;
use App\Models\Backend\Provider;
use App\Models\Backend\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Exam extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuids;

    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * Get the exam's slug.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value)
        );
    }
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
    ];

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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(ExamSession::class);
    }
}
