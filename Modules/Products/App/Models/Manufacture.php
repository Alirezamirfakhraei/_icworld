<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Manufacture extends Model
{
    use HasFactory;

    protected $table = 'manufactures';
    public const COL_MFR = 'mfr';
    public const COL_STATUS = 'status';

    protected $fillable = [
        self::COL_MFR,
        self::COL_STATUS,
    ];

}
