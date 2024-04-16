<?php

namespace Modules\Categories\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected   $table = 'category';
    const UPDATED_AT = null;
    public const COL_TITLE = 'title';

    public const COL_STATUS = 'status';
    public const REQ_VERSION = 'version';
    public const STATUS_ACTIVE = 'active';
    public const  STATUS_INACTIVE = 'inactive';
    public static array $status = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $fillable = [
        self::COL_TITLE,
        self::COL_STATUS,
    ];

    public function cat()
    {
        return $this->hasMany(CategorySub::class , 'catID' , 'id');
    }
}
