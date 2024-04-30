<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Products\App\Models\Product;

class GetProductPtnRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Product::COL_DK_PART_NUMBER => 'required|string|min:1|max:10',
            Product::COL_ICE_PART_NUMBER => 'required|string|min:1|max:10',
        ];
    }
}
