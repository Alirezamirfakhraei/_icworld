<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Products\App\Models\Product;

class GetProductPtnRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Product::REQ_MFR_PART_NUMBER => 'nullable|string|min:1|max:100|rex_english_na',
            Product::REQ_ICE_PART_NUMBER => 'nullable|string|min:1|max:100|rex_id_products',
            Product::REQ_DEC_IC => 'nullable|string|rex_english_na',
        ];
    }
}
