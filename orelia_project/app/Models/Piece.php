<?php

namespace App\Models;

use App\Contracts\Storage\ImageStorageInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Piece extends Model
{
    use HasFactory;

    public const DEFAULT_IMAGE = 'https://via.placeholder.com/400x400?text=No+Image';

    /**
     * PIECE ATTRIBUTES
     * $this->attributes['id'] - int - contains the piece primary key
     * $this->attributes['name'] - string - contains the piece name
     * $this->attributes['description'] - string - contains the piece description
     * $this->attributes['price'] - float - contains the piece price
     * $this->attributes['type'] - string - contains the piece type
     * $this->attributes['image_url'] - string - contains the piece image URL
     * $this->attributes['stock'] - int - contains the piece stock
     * $this->attributes['size'] - string - contains the piece size
     * $this->attributes['weight'] - float - contains the piece weight
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     * $this->attributes['collection_id'] - int - contains the piece collection foreign key
     * $this->collection - Collection - contains the piece collection object
     * $this->materials - Material[] - contains the piece materials list
     * $this->orderItems - OrderItem[] - contains the piece order items list
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

    // Getters & setters

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getPrice(): float
    {
        return $this->attributes['price'];
    }

    public function setPrice(float $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getType(): string
    {
        return $this->attributes['type'];
    }

    public function setType(string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function getImageUrl(): string
    {
        $imageUrl = $this->attributes['image_url'];

        if ($imageUrl === null) {
            return self::DEFAULT_IMAGE;
        }

        if (str_starts_with($imageUrl, 'http')) {
            return $imageUrl;
        }

        return app(ImageStorageInterface::class)->getUrl($imageUrl);
    }

    public function getImagePath(): ?string
    {
        return $this->attributes['image_url'];
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->attributes['image_url'] = $imageUrl;
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function getSize(): ?string
    {
        return $this->attributes['size'];
    }

    public function setSize(?string $size): void
    {
        $this->attributes['size'] = $size;
    }

    public function getWeight(): ?float
    {
        return $this->attributes['weight'];
    }

    public function setWeight(?float $weight): void
    {
        $this->attributes['weight'] = $weight;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    // FK getters & setters

    public function getCollectionId(): int
    {
        return $this->attributes['collection_id'];
    }

    public function setCollectionId(int $collectionId): void
    {
        $this->attributes['collection_id'] = $collectionId;
    }

    // Relations

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'piece_material');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relation getters

    public function getCollection(): Collection
    {
        return $this->relationLoaded('collection')
            ? $this->relations['collection']
            : $this->collection()->first();
    }

    public function getMaterials(): EloquentCollection
    {
        return $this->relationLoaded('materials')
            ? $this->relations['materials']
            : $this->materials()->get();
    }

    public function getOrderItems(): EloquentCollection
    {
        return $this->relationLoaded('orderItems')
            ? $this->relations['orderItems']
            : $this->orderItems()->get();
    }
}
