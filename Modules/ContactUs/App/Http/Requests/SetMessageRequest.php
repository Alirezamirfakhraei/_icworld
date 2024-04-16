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
            ContactUs::COL_EMAIL => 'required|string|max:100|rex_email',
            ContactUs::COL_MESSAGE => 'required|string|max:500|rex_text',
            ContactUs::COL_SUBJECT => 'nullable|string|max:256|rex_text',
            ContactUs::COL_FULL_NAME => 'nullable|string|max:100|rex_english_na',
        ];
    }
}

