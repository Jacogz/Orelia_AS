<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

use App\Models\Piece;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Collection as EloquentCollection;

class Collection extends Model
{
    use HasFactory;
    /**
     * COLLECTION ATTRIBUTES
     * $this->attributes['id'] - int - contains the collection primary key
     * $this->attributes['name'] - string - contains the collection name
     * $this->pieces - Piece[] - contains the collection pieces list
     * $this->attributes['created_at'] - timestamp - contains the collection creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the collection update timestamp
     */

    protected $fillable = [
        'name',
        'description'
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

    // Getters for related models
    public function getPieces(): EloquentCollection
    {
        return $this->pieces;
    }


}