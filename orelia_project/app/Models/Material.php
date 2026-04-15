<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class Material extends Model
{
    use HasFactory;

    /**
     * MATERIAL ATTRIBUTES
     * $this->attributes['id'] - int - contains the material primary key
     * $this->attributes['name'] - string - contains the material name
     * $this->attributes['type'] - string - contains the material type
     * $this->attributes['description'] - string - contains the material description
     * $this->attributes['color'] - string - contains the material color
     * $this->pieces - Piece[] - contains the material pieces list
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     */

    protected $fillable = [
        'name',
        'type',
        'description',
        'color',
    ];

    public static function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:30|min:3',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'color' => 'required|string|max:30|min:3',
        ]);
    }

    public function pieces(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getType(): string
    {
        return $this->attributes['type'];
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function getColor(): string
    {
        return $this->attributes['color'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setType(string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function setColor(string $color): void
    {
        $this->attributes['color'] = $color;
    }

    // Getters for related models

    public function getPieces(): EloquentCollection
    {
        return $this->pieces;
    }
}