<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PieceCollection;
use App\Http\Resources\PieceResource;
use App\Models\Piece;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PieceApiController extends Controller
{
    private const PER_PAGE = 10;

    public function index(Request $request): JsonResponse
    {
        $query = Piece::query()->where('stock', '>', 0)->with('collection');

        if ($this->shouldIncludeMaterials($request)) {
            $query->with('materials');
        }

        $pieces = new PieceCollection($query->paginate(self::PER_PAGE));

        return response()->json($pieces, 200);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $relations = ['collection'];
        if ($this->shouldIncludeMaterials($request)) {
            $relations[] = 'materials';
        }

        $piece = Piece::with($relations)->findOrFail($id);

        return response()->json(new PieceResource($piece), 200);
    }

    private function shouldIncludeMaterials(Request $request): bool
    {
        $include = $request->query('include', '');
        $tokens = array_map('trim', explode(',', (string) $include));

        return in_array('materials', $tokens, true);
    }
}
