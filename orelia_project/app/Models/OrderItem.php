<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class OrderItem extends Model
{
    /**
     * ORDER ITEM ATTRIBUTES
     * $this->attributes['id'] - int - contains the order item primary key
     * $this->attributes['unit_price'] - int - contains the order item unit price
     * $this->attributes['quantity'] - int - contains the order item quantity
     * $this->attributes['subtotal'] - int - contains the order item subtotal
     * $this->attributes['order_id'] - int - contains the order item order foreign key
     * $this->attributes['piece_id'] - int - contains the order item piece foreign key
     * $this->order - Order - contains the order item order object
     * $this->piece - Piece - contains the order item piece object
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     */
    protected $fillable = [
        'unit_price',
        'quantity',
        'subtotal',
        'order_id',
        'piece_id',
    ];

    public static function validate(Request $request): array
    {
        return $request->validate([
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'order_id' => 'required|integer|exists:orders,id',
            'piece_id' => 'required|integer|exists:pieces,id',
        ]);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class, 'piece_id');
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getUnitPrice(): int
    {
        return $this->attributes['unit_price'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function getSubtotal(): int
    {
        return $this->attributes['subtotal'];
    }

    public function setUnitPrice(int $unitPrice): void
    {
        $this->attributes['unit_price'] = $unitPrice;
    }

    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function setSubtotal(int $subtotal): void
    {
        $this->attributes['subtotal'] = $subtotal;
    }

    public function calculateSubtotal(): int
    {
        return $this->getUnitPrice() * $this->getQuantity();
    }

    // Getters for related models

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getPiece(): Piece
    {
        return $this->piece;
    }
}
