<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCollectionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Collection::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', '%'.$request->description.'%');
        }

        $collections = $query->get();

        $viewData = [];
        $viewData['title'] = __('collections.title');
        $viewData['collections'] = $collections;

        return view('admin.collections.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('collections.create_title');

        return view('admin.collections.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $validationData = Collection::validate($request);

        try {
            $collection = new Collection;
            $collection->fill($validationData);
            $collection->save();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('collections.error'));
        }

        return redirect()->route('admin.collections.index')
            ->with('success', __('collections.created'));
    }

    public function edit(string $id): View
    {
        $collection = Collection::findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('collections.edit_title');
        $viewData['collection'] = $collection;

        return view('admin.collections.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validationData = Collection::validate($request);

        try {
            $collection = Collection::findOrFail($id);
            $collection->fill($validationData);
            $collection->save();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('collections.error'));
        }

        return redirect()->route('admin.collections.index')
            ->with('success', __('collections.updated'));
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $collection = Collection::findOrFail($id);
            $collection->delete();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('collections.error'));
        }

        return redirect()->route('admin.collections.index')
            ->with('success', __('collections.deleted'));
    }
}
