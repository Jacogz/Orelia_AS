<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Order extends Model
{
    use HasFactory;
    /**
     * ORDER ATTRIBUTES
     * $this->attributes['id'] - int - contains the order primary key
     * $this->attributes['total'] - int - contains the order total
     * $this->attributes['status'] - string - contains the order status
     * $this->attributes['payment_method'] - string - contains the payment method
     * $this->attributes['payment_status'] - string - contains the payment status
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     * $this->order_items - OrderItem[] - contains the order items list
     * $this->attributes['user_id'] - int - contains the order client ID
     * $this->user - User - contains the order client object
     */
    protected $fillable = [
        'user_id',
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
            'user_id' => 'required|integer|exists:users,id',
        ]);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getTotal(): int
    {
        return $this->attributes['total'];
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function getPaymentMethod(): string
    {
        return $this->attributes['payment_method'];
    }

    public function getPaymentStatus(): string
    {
        return $this->attributes['payment_status'];
    }

    public function setTotal(int $total): void
    {
        $this->attributes['total'] = $total;
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->attributes['payment_method'] = $paymentMethod;
    }

    public function setPaymentStatus(string $paymentStatus): void
    {
        $this->attributes['payment_status'] = $paymentStatus;
    }

    // Getters for related models

    public function getOrderItems(): EloquentCollection
    {
        return $this->order_items;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    // Methods for managing order items

    public function addOrderItem(OrderItem $orderItem): void
    {
        $orderItem->order_id = $this->getId();
        $orderItem->save();
    }

    public function removeOrderItem(OrderItem $orderItem): void
    {
        $orderItem->delete();
    }
}
