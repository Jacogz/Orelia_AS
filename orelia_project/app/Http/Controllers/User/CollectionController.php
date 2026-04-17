<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Exception;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        try {
            $collections = Collection::all();
            $viewData = [];
            $viewData['title'] = __('collections.title');
            $viewData['subtitle'] = __('collections.subtitle');
            $viewData['collections'] = $collections;

            return view('user.collections.index')->with('viewData', $viewData);
        } catch (Exception $e) {
            $viewData = [];
            $viewData['title'] = __('collections.title');
            $viewData['collections'] = collect();

            return view('user.collections.index')->with('viewData', $viewData);
        }
    }

    public function show(string $id): View
    {
        try {
            $collection = Collection::with('pieces')->findOrFail($id);
            $viewData = [];
            $viewData['title'] = $collection->getName();
            $viewData['collection'] = $collection;
            $viewData['pieces'] = $collection->getPieces();

            return view('user.collections.show')->with('viewData', $viewData);
        } catch (Exception $e) {
            $viewData = [];
            $viewData['title'] = __('collections.title');
            $viewData['collection'] = null;
            $viewData['pieces'] = collect();

            return view('user.collections.show')->with('viewData', $viewData);
        }
    }
}
