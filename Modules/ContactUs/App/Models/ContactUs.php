<?php

namespace Modules\ContactUs\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUs extends Model
{
    use HasFactory;

    public const COL_USERID = 'userID';
    public const COL_EMAIL = 'email';
    public const COL_FULL_NAME = 'fullName';
    public const COL_SUBJECT = 'subject';
    public const COL_MESSAGE = 'message';
    public const COL_STATUS = 'status';


    public const REQ_USERID = 'userID';
    public const REQ_EMAIL = 'email';
    public const REQ_FULL_NAME = 'fullName';
    public const REQ_SUBJECT = 'subject';
    public const REQ_MESSAGE = 'message';

    protected $fillable = [
        self::COL_USERID,
        self::COL_EMAIL,
        self::COL_FULL_NAME,
        self::COL_SUBJECT,
        self::COL_MESSAGE,
        self::COL_STATUS,
    ];

}
