<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $property = $this->route('property');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('properties', 'slug')->ignore($property),
            ],

            'description' => [
                'required',
                'string',
            ],

            'property_type_id' => [
                'required',
                'exists:property_types,code',
            ],

            'operations' => [
                'required',
                'array',
                'min:1',
            ],

            'operations.*.operation_type_id' => [
                'required',
                'integer',
                'exists:operation_types,id',
            ],

            'operations.*.price' => [
                'required',
                'numeric',
            ],

            'operations.*.currency' => [
                'required',
                'string',
                'max:10',
                'exists:currencies,code',
            ],

            'operations.*.status' => [
                'required',
                'string',
                'exists:property_statuses,code',
            ],

            'images' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function validatedProperty(): array
    {
        $propertyId = $this->route('property');

        $data = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('properties', 'slug')->ignore($propertyId)],
            'description' => ['required', 'string'],
            'property_type_id' => ['required', 'exists:property_types,code'],
        ]);

        $data['property_type_id'] = \App\Models\PropertyType::where('code', $this->input('property_type_id'))->value('id');

        return $data;
    }

    public function validatedOperations(): array
    {
        $operations = $this->input('operations', []);

        return $this->validate([
            'operations' => ['required', 'array', 'min:1'],
            'operations.*.operation_type_id' => ['required', 'integer', 'exists:operation_types,id'],
            'operations.*.price' => ['required', 'numeric'],
            'operations.*.currency' => ['required', 'string', 'max:10', 'exists:currencies,code'],
            'operations.*.status' => ['required', 'string', 'exists:property_statuses,code'],
        ])['operations'] ?? $operations;
    }
}
