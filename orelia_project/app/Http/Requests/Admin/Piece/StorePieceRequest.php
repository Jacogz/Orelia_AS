<?php

namespace App\Http\Requests\Admin\Piece;

use Illuminate\Foundation\Http\FormRequest;

class StorePieceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'piece_image' => 'nullable|image',
            'piece_web_url' => 'nullable|url|max:2048',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'collection_id' => 'required|integer|exists:collections,id',
        ];
    }
}
