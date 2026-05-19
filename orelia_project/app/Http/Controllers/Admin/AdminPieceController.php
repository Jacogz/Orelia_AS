<?php

namespace App\Http\Controllers\Admin;

use App\Filters\PieceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Piece\StorePieceRequest;
use App\Http\Requests\Admin\Piece\UpdatePieceRequest;
use App\Interfaces\ImageStorage;
use App\Models\Collection;
use App\Models\Piece;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPieceController extends Controller
{
    private PieceFilter $pieceFilter;

    public function __construct(PieceFilter $pieceFilter)
    {
        $this->pieceFilter = $pieceFilter;
    }

    public function index(Request $request): View
    {
        $query = Piece::with('collection');
        $this->pieceFilter->apply($query, $request);

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

    public function store(StorePieceRequest $request): RedirectResponse
    {
        $storeInterface = app(ImageStorage::class);
        $storeInterface->store($request);

        $validationData = $request->validated();
        if ($request->hasFile('piece_image')) {
            $validationData['image_url'] = 'pieces/'.$request->file('piece_image')->hashName();
        }

        $piece = new Piece;
        $piece->fill($validationData);
        $piece->save();

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

    public function update(UpdatePieceRequest $request, string $id): RedirectResponse
    {
        $storeInterface = app(ImageStorage::class);
        $storeInterface->store($request);

        $validationData = $request->validated();
        if ($request->hasFile('piece_image')) {
            $validationData['image_url'] = 'pieces/'.$request->file('piece_image')->hashName();
        }

        $piece = Piece::findOrFail($id);
        $piece->fill($validationData);
        $piece->save();

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
