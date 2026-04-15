<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Collection extends Model
{
    use HasFactory;

    /**
     * COLLECTION ATTRIBUTES
     * $this->attributes['id'] - int - contains the collection primary key
     * $this->attributes['name'] - string - contains the collection name
     * $this->attributes['description'] - string - contains the collection description
     * $this->pieces - Piece[] - contains the collection pieces list
     * $this->attributes['created_at'] - timestamp - contains the collection creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the collection update timestamp
     */

    protected $fillable = [
        'name',
        'description',
    ];

    public static function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'nullable|string|max:255',
        ]);
    }

    public function pieces(): HasMany
    {
        return $this->hasMany(Piece::class);
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

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    // Getters for related models

    public function getPieces(): EloquentCollection
    {
        return $this->pieces;
    }
}