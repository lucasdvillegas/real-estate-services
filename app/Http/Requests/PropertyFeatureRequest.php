<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $propertyFeature = $this->route('propertyfeature');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('property_features', 'code')->ignore(is_string($propertyFeature) ? $propertyFeature : data_get($propertyFeature, 'id')),
            ],
        ];
    }

}
