<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Products\App\Models\Product;

class GetProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Product::REQ_DEC_IC => 'required|string|rex_english_na',
        ];
    }
}
