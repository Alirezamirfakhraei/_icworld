<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    public const STATUS_ACTIVE = 'active';
    public const  STATUS_INACTIVE = 'inactive';
    public static array $status = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($query) {
            $query->status = self::STATUS_ACTIVE;
        });
    }


}
