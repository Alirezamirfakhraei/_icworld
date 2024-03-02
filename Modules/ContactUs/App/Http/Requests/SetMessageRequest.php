<?php

namespace Modules\ContactUs\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\ContactUs\App\Models\ContactUs;

class SetMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            ContactUs::COL_USERID => '',
            ContactUs::COL_EMAIL => '',
            ContactUs::COL_SUBJECT => '',
            ContactUs::COL_MESSAGE => '',
            ContactUs::COL_FULL_NAME => '',
        ];
    }
}
