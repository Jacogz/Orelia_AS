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
        $viewData = [];
        $viewData['title'] = __('pieces.title');
        $viewData['pieces'] = $pieces;

        return view('pieces.admin.index', ['viewData' => $viewData]);
    }

    public function create(): View
    {
        $collections = Collection::all();
        $viewData = [];
        $viewData['title'] = __('pieces.create_title');
        $viewData['collections'] = $collections;

        return view('pieces.admin.create', ['viewData' => $viewData]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validationData = Piece::validate($request);
            $piece = new Piece();
            $piece->fill($validationData);
            $piece->save();

            return redirect()->route('admin.pieces.index')
                ->with('success', __('pieces.created'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('pieces.error'));
        }
    }

    public function edit(string $id): View
    {
        $piece = Piece::findOrFail($id);
        $collections = Collection::all();
        $viewData = [];
        $viewData['title'] = __('pieces.edit_title');
        $viewData['piece'] = $piece;
        $viewData['collections'] = $collections;

        return view('pieces.admin.edit', ['viewData' => $viewData]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        try {
            $piece = Piece::findOrFail($id);
            $validationData = Piece::validate($request);
            $piece->fill($validationData);
            $piece->save();

            return redirect()->route('admin.pieces.index')
                ->with('success', __('pieces.updated'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('pieces.error'));
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $piece = Piece::findOrFail($id);
            $piece->delete();

            return redirect()->route('admin.pieces.index')
                ->with('success', __('pieces.deleted'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('pieces.error'));
        }
    }
}