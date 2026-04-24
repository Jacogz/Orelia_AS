<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
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
        $viewData['subtitle'] = __('collections.subtitle');
        $viewData['collections'] = $collections;

        return view('user.collections.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $collection = Collection::with('pieces')->findOrFail($id);

        $viewData = [];
        $viewData['title'] = $collection->getName();
        $viewData['collection'] = $collection;
        $viewData['pieces'] = $collection->getPieces();

        return view('user.collections.show')->with('viewData', $viewData);
    }
}
