<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Schema;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Visus\Cuid2\Cuid2;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstName',
        'lastName',
        'role',
        'email',
        'email_verified_at',
        'password',
        'isActive',
        'remember_token',
        'last_login',
        'branchId'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            // Check if the model's table has a 'cuid' column to avoid errors
            // and if a cuid has not already been set manually.
            if (empty($model->cuid) && Schema::hasColumn($model->getTable(), $model->cuid)) {

                // Your provided logic for generating the CUID.
                // We use a fixed size of 24 here as a sensible default.
                $size = config('app.cuid_size', 24);
                $model->cuid = new Cuid2(maxLength: ($size < 4 || $size > 32) ? 24 : $size)->toString();
            }
        });

    }


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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'email' => $this->email,
            'role' => $this->role,
            'branchId' => $this->branchId,
            'isActive' => $this->isActive,
        ];
    }

    public function branch(): HasOne|Branch
    {
        return $this->hasOne(Branch::class, 'branchId', 'branchId');
    }
}
