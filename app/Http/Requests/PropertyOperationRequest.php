<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PropertyOperationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{
     *   type: array<int, string>,
     *   price: array<int, string>,
     *   currency: array<int, string>,
     *   status: array<int, string>,
     *   available_from: array<int, string>,
     *   property_id: array<int, int>,
     * }
     */
    public function rules(): array
    {
        return [
            'property_id' => [
                'required',
                'exists:properties,id',
            ],

            'type' => [
                'required',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
            ],

            'currency' => [
                'required',
                'string',
                'max:10',
            ],

            'status' => [
                'required',
                'string',
            ],

            'available_from' => [
                'nullable',
                'date',
            ],
        ];
    }

}
