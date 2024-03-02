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
            ContactUs::COL_EMAIL => 'required|string|min:2|max:100|',
            ContactUs::COL_SUBJECT => 'nullable|string|min:2|max:100|',
            ContactUs::COL_MESSAGE => 'required|string|min:2|max:100|',
            ContactUs::COL_FULL_NAME => 'required|string|min:2|max:100|regex:/^[a-zA-Z0-9 ]+$/',
        ];
    }
}

