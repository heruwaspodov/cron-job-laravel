<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 *
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gender',
        'name',
        'location',
        'age'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->setAttribute($model->getKeyName(), Str::uuid());
        });
        static::deleted(function ($model) {
            $model->setAttribute($model->getKeyName(), Str::uuid());
        });
    }

}
