<?php

namespace Modules\Categories\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryBranch extends Model
{
    use HasFactory;

    protected $table = 'category_branch';
    public const COL_LINK = 'link';
    public const COL_TITLE = 'title';
    public const COL_SUB_ID = 'subCatID';
    public const COL_URL = 'url';

    public const COL_COUNT = 'count';
    public const COL_STATUS = 'status';
    public const STATUS_ACTIVE = 'active';
    public const  STATUS_INACTIVE = 'inactive';
    public static array $status = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $fillable = [
        self::COL_COUNT,
        self::COL_TITLE,
        self::COL_SUB_ID,
        self::COL_URL,
        self::COL_STATUS,
    ];

    public function subcategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CategorySub::class, 'id', 'subCatID');
    }

}
