<?php

namespace App\Http\Requests\Admin\Material;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:30',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'color' => 'required|string|min:3|max:30',
        ];
    }
}
