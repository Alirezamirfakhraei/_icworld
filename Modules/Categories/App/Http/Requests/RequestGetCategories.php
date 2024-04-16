<?php

namespace Modules\Categories\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Categories\App\Models\Category;

class RequestGetCategories extends FormRequest
{
    public function rules(): array
    {
        return [
            Category::REQ_VERSION => 'nullable|string|rex_version',
        ];
    }

}
