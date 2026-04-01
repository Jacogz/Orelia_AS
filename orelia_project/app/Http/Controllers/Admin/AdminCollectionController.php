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
        return view('collections.admin.index', ['collections' => $collections]);
    }

    public function create(): View
    {
        return view('collections.admin.create');
    }

    public function store(Request $request): RedirectResponse
    {
       $data = Collection::validate($request);
        Collection::create($data);
        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection created successfully.');
    }

    public function edit(string $id): View
    {
        $collection = Collection::findOrFail($id);
        return view('collections.admin.edit', ['collection' => $collection]);
    }

      public function update(Request $request, string $id): RedirectResponse
    {
        $collection = Collection::findOrFail($id);
        $data = Collection::validate($request);
        $collection->update($data);
        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();
        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully.');
    }
}
