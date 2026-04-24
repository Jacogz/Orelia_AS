<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPieceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Piece::with('collection');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('collection_id')) {
            $query->where('collection_id', $request->collection_id);
        }

        if ($request->filled('stock') && $request->stock === 'available') {
            $query->where('stock', '>', 0);
        }

        $pieces = $query->get();
        $collections = Collection::all();
        $types = Piece::select('type')->distinct()->pluck('type');

        $viewData = [];
        $viewData['title'] = __('pieces.title');
        $viewData['pieces'] = $pieces;
        $viewData['collections'] = $collections;
        $viewData['types'] = $types;

        return view('admin.pieces.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $collections = Collection::all();

        $viewData = [];
        $viewData['title'] = __('pieces.create_title');
        $viewData['collections'] = $collections;

        return view('admin.pieces.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $validationData = Piece::validate($request);

        try {
            $piece = new Piece;
            $piece->fill($validationData);
            $piece->save();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('pieces.error'));
        }

        return redirect()->route('admin.pieces.index')
            ->with('success', __('pieces.created'));
    }

    public function edit(string $id): View
    {
        $piece = Piece::findOrFail($id);
        $collections = Collection::all();

        $viewData = [];
        $viewData['title'] = __('pieces.edit_title');
        $viewData['piece'] = $piece;
        $viewData['collections'] = $collections;

        return view('admin.pieces.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validationData = Piece::validate($request);

        try {
            $piece = Piece::findOrFail($id);
            $piece->fill($validationData);
            $piece->save();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('pieces.error'));
        }

        return redirect()->route('admin.pieces.index')
            ->with('success', __('pieces.updated'));
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $piece = Piece::findOrFail($id);
            $piece->delete();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('pieces.error'));
        }

        return redirect()->route('admin.pieces.index')
            ->with('success', __('pieces.deleted'));
    }
}
