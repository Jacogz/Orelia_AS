<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'piece_id' => 'required|integer|exists:pieces,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'piece_id' => $this->route('id'),
        ]);
    }
}
