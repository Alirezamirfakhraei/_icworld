<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public const COL_DK_PART_NUMBER = '';
    public const COL_MFR_PART_NUMBER = '';
    public const COL_ICE_PART_NUMBER = '';
    public const COL_MFR = 'mfr';
    public const COL_CATEGORY = 'category';
    public const COL_CATEGORY_SUB = 'categorySub';
    public const COL_CATEGORY_BRANCH = 'categoryBranch';

    public const COL_CURRENCY = '';
    public const COL_DESCRIPTION = '';
    public const COL_PRICE = '';
    public const COL_STATUS = 'status';
    public const COL_IMAGE = 'image';
    public const COL_DATASHEET = 'dataSheet';

    public const STATUS_STOPPED = 'stopped';
    public const STATUS_AVAILABLE = 'available';
    public const  STATUS_UNAVAILABLE = 'unAvailable';
    public static array $status = [self::STATUS_AVAILABLE, self::STATUS_UNAVAILABLE];

    protected $fillable = [
    self::COL_DK_PART_NUMBER,
    self::COL_MFR_PART_NUMBER,
    self::COL_ICE_PART_NUMBER,
    self::COL_DESCRIPTION,
    self::COL_PRICE,
    self::COL_STATUS,
    self::COL_IMAGE,
    self::COL_DATASHEET,
    ];
}
