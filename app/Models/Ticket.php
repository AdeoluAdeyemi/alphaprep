<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    use HasUuids;

    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // if (empty($model->{uuid})) {
            //     $model->{uuid} = Str::uuid();
            // }

            if (empty($model->{$model->getKeyName()})) { // if it's not empty, then we want to use a specific id
                $model->{$model->getKeyName()} = Str::uuid(); //(string)Uuid::uuid4();
            }
        });
    }
}
