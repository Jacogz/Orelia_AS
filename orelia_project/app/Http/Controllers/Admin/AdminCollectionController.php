<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCollectionController extends Controller
{
    public function index(): View
    {
        $collections = Collection::all();
        $viewData = [];
        $viewData['title'] = __('collections.title');
        $viewData['collections'] = $collections;

        return view('collections.admin.index', ['viewData' => $viewData]);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('collections.create_title');

        return view('collections.admin.create', ['viewData' => $viewData]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validationData = Collection::validate($request);
            $collection = new Collection;
            $collection->fill($validationData);
            $collection->save();

            return redirect()->route('admin.collections.index')
                ->with('success', __('collections.created'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('collections.error'));
        }
    }

    public function edit(string $id): View
    {
        $collection = Collection::findOrFail($id);
        $viewData = [];
        $viewData['title'] = __('collections.edit_title');
        $viewData['collection'] = $collection;

        return view('collections.admin.edit', ['viewData' => $viewData]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        try {
            $collection = Collection::findOrFail($id);
            $validationData = Collection::validate($request);
            $collection->fill($validationData);
            $collection->save();

            return redirect()->route('admin.collections.index')
                ->with('success', __('collections.updated'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('collections.error'));
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $collection = Collection::findOrFail($id);
            $collection->delete();

            return redirect()->route('admin.collections.index')
                ->with('success', __('collections.deleted'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('collections.error'));
        }
    }
}
