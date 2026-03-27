<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /**
     * ORDER ITEM ATTRIBUTES
     * $this->attributes['id'] - int - contains the order item primary key
     * $this->attributes['unit_price'] - int - contains the order item unit price
     * $this->attributes['quantity'] - int - contains the order item quantity
     * $this->attributes['subtotal'] - int - contains the order item total price
     * $this->attributes['order'] - Order - contains the order item order object (fk order_id)
     * $this->attributes['piece'] - Piece - contains the order item piece object (fk piece_id)
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     */

    protected $fillable = [
        'unit_price',
        'quantity',
        'subtotal',
        'order_id',
        'piece_id'
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