<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Cashier\Billable;
use App\Models\Backend\Category;
use App\Models\Feedback;
//use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable implements CanUseTickets
{
    use
//    HasApiTokens,
    HasFactory,
    SoftDeletes,
    HasRoles,
    Billable,
    HasUuids,
    HasTickets,
    Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'facebook_id',
        'google_id',
        'github_id',
        'address',
        'city',
        'state',
        'country',
        'currency',
        'timezone',
        'zip_code',
        'locale'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

        /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public $incrementing = false;
    // protected $keyType = 'string';

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    // public function feedbacks(): HasMany
    // {
    //     return $this->hasMany(Feedback::class);
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}


/**
 * Class Uuid.
 * Manages the usage of creating UUID values for primary keys. Drop into your models as
 * per normal to use this functionality. Works right out of the box.
 * Taken from: http://garrettstjohn.com/entry/using-uuids-laravel-eloquent-orm/
 */
// trait UuidForKey
// {

//     /**
//      * The "booting" method of the model.
//      */
//     public static function bootUuidForKey()
//     {
//         static::retrieved(function (Model $model) {
//             $model->incrementing = false;  // this is used after instance is loaded from DB
//         });

//         static::creating(function (Model $model) {
//             $model->incrementing = false; // this is used for new instances

//             if (empty($model->{$model->getKeyName()})) { // if it's not empty, then we want to use a specific id
//                 $model->{$model->getKeyName()} = (string)Uuid::uuid4();
//             }
//         });
//     }

//     public function initializeUuidForKey()
//     {
//         $this->keyType = 'string';
//     }
// }


// namespace App\Models;

// // use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable
// {
//     /** @use HasFactory<\Database\Factories\UserFactory> */
//     use HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var list<string>
//      */
//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//     ];

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var list<string>
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * Get the attributes that should be cast.
//      *
//      * @return array<string, string>
//      */
//     protected function casts(): array
//     {
//         return [
//             'email_verified_at' => 'datetime',
//             'password' => 'hashed',
//         ];
//     }
// }
