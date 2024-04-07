<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 *
 */
class DailyRecord extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'male_count',
        'female_count',
        'male_avg_age',
        'female_avg_age'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->setAttribute($model->getKeyName(), Str::uuid());
        });
    }

}
