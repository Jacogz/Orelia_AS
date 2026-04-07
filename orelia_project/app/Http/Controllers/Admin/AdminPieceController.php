<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPieceController extends Controller
{
    public function index(): View
    {
        $pieces = Piece::with('collection')->get();

        return view('pieces.admin.index', ['pieces' => $pieces]);
    }

    public function create(): View
    {
        $collections = Collection::all();

        return view('pieces.admin.create', ['collections' => $collections]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = Piece::validate($request);
        Piece::create($data);

        return redirect()->route('admin.pieces.index')
            ->with('success', 'Piece created successfully.');
    }

    public function edit(string $id): View
    {
        $piece = Piece::findOrFail($id);
        $collections = Collection::all();

        return view('pieces.admin.edit', ['piece' => $piece, 'collections' => $collections]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $piece = Piece::findOrFail($id);
        $data = Piece::validate($request);
        $piece->update($data);

        return redirect()->route('admin.pieces.index')
            ->with('success', 'Piece updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $piece = Piece::findOrFail($id);
        $piece->delete();

        return redirect()->route('admin.pieces.index')
            ->with('success', 'Piece deleted successfully.');
    }
}
