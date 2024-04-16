<?php

namespace Modules\Categories\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategorySub extends Model
{

    protected $table = 'category_sub';
    use HasFactory;
    public const COL_TITLE = 'title';
    public const COL_CAT_ID = 'catID';
    public const COL_URL = 'url';
    public const COL_COUNT = 'count';

    public const COL_STATUS = 'status';
    public const STATUS_ACTIVE = 'active';
    public const  STATUS_INACTIVE = 'inactive';
    public static array $status = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];
    protected $fillable = [
        self::COL_COUNT,
        self::COL_TITLE,
        self::COL_CAT_ID,
        self::COL_URL,
        self::COL_STATUS,
    ];

    public function subCat()
    {
        return $this->hasMany(CategoryBranch::class , 'subCatID' , 'id');
    }
}
