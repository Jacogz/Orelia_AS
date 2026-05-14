<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * $this->attributes['user_id'] - int - contains the order user foreign key
     * $this->user - User - contains the order user object
     * $this->order_items - OrderItem[] - contains the order items list
     */
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_method',
        'payment_status',
    ];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getTotal(): int
    {
        return $this->attributes['total'];
    }

    public function setTotal(int $total): void
    {
        $this->attributes['total'] = $total;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getPaymentMethod(): string
    {
        return $this->attributes['payment_method'];
    }

    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->attributes['payment_method'] = $paymentMethod;
    }

    public function getPaymentStatus(): string
    {
        return $this->attributes['payment_status'];
    }

    public function setPaymentStatus(string $paymentStatus): void
    {
        $this->attributes['payment_status'] = $paymentStatus;
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getUser(): ?User
    {
        return $this->relationLoaded('user') ? $this->relations['user'] : $this->user()->first();
    }

    public function getOrderItems(): EloquentCollection
    {
        return $this->relationLoaded('orderItems') ? $this->relations['orderItems'] : $this->orderItems()->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addOrderItem(OrderItem $orderItem): void
    {
        $orderItem->setOrderId($this->getId());
        $orderItem->save();
    }

    public function removeOrderItem(OrderItem $orderItem): void
    {
        $orderItem->delete();
    }
}
