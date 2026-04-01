<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Piece extends Model
{
    use HasFactory;

    /**
     * PIECE ATTRIBUTES
     * $this->attributes['id'] - int - contains the piece primary key
     * $this->attributes['name'] - string - contains the piece name
     * $this->attributes['description'] - string - contains the piece description
     * $this->attributes['price'] - int - contains the piece price
     * $this->attributes['type'] - string - contains the piece type
     * $this->attributes['image_url'] - string - contains the piece image URL
     * $this->attributes['stock'] - int - contains the piece stock
     * $this->attributes['size'] - string - contains the piece size
     * $this->attributes['weight'] - int - contains the piece weight
     * $this->attributes['collection'] - Collection - contains the piece collection object (fk collection_id)
     * $this->attributes['materials'] - Material[] - contains the piece materials list
     * $this->attributes['order_items'] - OrderItem[] - contains the piece order items list
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'image_url',
        'stock',
        'size',
        'weight',
        'collection_id',
    ];

    public static function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'collection_id' => 'required|integer|exists:collections,id',
        ]);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    public function getPrice(): float
    {
        return $this->attributes['price'];
    }

    public function getType(): string
    {
        return $this->attributes['type'];
    }

    public function getImageUrl(): ?string
    {
        return $this->attributes['image_url'];
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function getSize(): ?string
    {
        return $this->attributes['size'];
    }

    public function getWeight(): ?float
    {
        return $this->attributes['weight'];
    }

    public function getCollectionId(): int
    {
        return $this->attributes['collection_id'];
    }
    // Getters for related models

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function getMaterials(): EloquentCollection
    {
        return $this->materials;
    }

    public function getOrderItems(): EloquentCollection
    {
        return $this->orderItems;
    }
}
