<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Order extends Model
{
    /**
     * ORDER ATTRIBUTES
     * $this->attributes['id'] - int - contains the order primary key
     * $this->attributes['total'] - int - contains the order total
     * $this->attributes['status'] - string - contains the order status
     * $this->attributes['payment_method'] - string - contains the payment method
     * $this->attributes['payment_status'] - string - contains the payment status
     * $this->attributes['client_id'] - int - contains the order client ID
     * $this->attributes['order_items'] - OrderItem[] - contains the order items list
     */
    protected $fillable = [
        'client_id',
        'total',
        'status',
        'payment_method',
        'payment_status',
    ];

    public static function validate(Request $request): array
    {
        return $request->validate([
            'total' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|string|max:255',
            'client_id' => 'required|integer|exists:users,id',
        ]);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Getters for related models
    public function getOrderItems(): EloquentCollection
    {
        return $this->orderItems;
    }

    public function getClient(): User
    {
        return $this->client;
    }
}
