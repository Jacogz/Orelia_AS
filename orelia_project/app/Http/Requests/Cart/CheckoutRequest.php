<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $cartData = $this->session()->get('cart', []);

            if (empty($cartData)) {
                $validator->errors()->add('cart', __('cart.empty'));

                return;
            }

            $validationData = [];
            foreach ($cartData as $pieceId => $quantity) {
                $validationData[] = [
                    'piece_id' => $pieceId,
                    'quantity' => $quantity,
                ];
            }

            $itemValidator = Validator::make($validationData, [
                '*.piece_id' => 'required|integer|exists:pieces,id',
                '*.quantity' => 'required|integer|min:1',
            ]);

            if ($itemValidator->fails()) {
                foreach ($itemValidator->errors()->all() as $error) {
                    $validator->errors()->add('cart_items', $error);
                }
            }
        });
    }

    public function validatedCart(): array
    {
        $cartData = $this->session()->get('cart', []);
        $validated = [];
        foreach ($cartData as $pieceId => $quantity) {
            $validated[$pieceId] = $quantity;
        }

        return $validated;
    }
}
