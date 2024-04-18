<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Modules\ContactUs\App\Models\ContactUs;
use Modules\Products\App\Models\Product;

class SearchProductsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Product::COL_DK_PART_NUMBER => 'required|integer|min:1|max:10',
            Product::COL_ICE_PART_NUMBER => 'required|integer|min:1|max:10',
        ];
    }

}

