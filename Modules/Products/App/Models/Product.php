<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public const COL_DK_PART_NUMBER = 'dk_part_number';
    public const COL_MFR_PART_NUMBER = 'mfr_part_number';
    public const COL_ICE_PART_NUMBER = 'ice_part_number';
    public const COL_MFR = 'mfr';
    public const COL_CATEGORY = 'categoryID';
    public const COL_CATEGORY_SUB = 'categorySubID';
    public const COL_CATEGORY_BRANCH = 'categoryBranchID';
    public const COL_CURRENCY = 'currency';
    public const COL_DESCRIPTION = 'description';
    public const COL_PRICE = 'price';
    public const COL_STATUS = 'status';
    public const COL_IMAGE = 'image';
    public const COL_DATASHEET = 'dataSheet';


    public const STATUS_STOPPED = 'stopped';
    public const STATUS_AVAILABLE = 'available';
    public const  STATUS_UNAVAILABLE = 'unAvailable';
    public static array $statuses = [self::STATUS_AVAILABLE, self::STATUS_UNAVAILABLE , self::STATUS_STOPPED];

    protected $fillable = [
    self::COL_DK_PART_NUMBER,
    self::COL_MFR_PART_NUMBER,
    self::COL_ICE_PART_NUMBER,
    self::COL_MFR,
    self::COL_CATEGORY,
    self::COL_CATEGORY_SUB,
    self::COL_CATEGORY_BRANCH,
    self::COL_CURRENCY,
    self::COL_DESCRIPTION,
    self::COL_PRICE,
    self::COL_STATUS,
    self::COL_IMAGE,
    self::COL_DATASHEET,
    ];

}
