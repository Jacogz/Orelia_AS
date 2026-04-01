<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

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
     * $this->attributes['pieces'] - Piece[] - contains the material pieces list
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     */

    protected $fillable = [
        'name',
        'type',
        'description',
        'color'
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

    // Getters for related models
    public function getPieces(): EloquentCollection
    {
        return $this->pieces;
    }
}