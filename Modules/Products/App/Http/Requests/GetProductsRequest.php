<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Modules\ContactUs\App\Models\ContactUs;

class GetProductsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function validationData(): ?array
    {
        return array_merge(
            $this->route()->parameters(),
            $this->all()
        );
    }

    public function rules(): array
    {
        return [
            'id' => 'required|string|rex_id_products',
            'ic' => 'required|string|rex_english_na',
        ];
    }

}

