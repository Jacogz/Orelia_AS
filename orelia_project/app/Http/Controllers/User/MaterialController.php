<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(Request $request): View
    {
        $query = Material::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('color')) {
            $query->where('color', 'like', '%'.$request->color.'%');
        }

        $materials = $query->get();
        $types = Material::select('type')->distinct()->pluck('type');

        $viewData = [];
        $viewData['title'] = __('materials.title');
        $viewData['subtitle'] = __('materials.subtitle');
        $viewData['materials'] = $materials;
        $viewData['types'] = $types;

        return view('user.materials.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $material = Material::findOrFail($id);

        $viewData = [];
        $viewData['title'] = $material->getName();
        $viewData['material'] = $material;

        return view('user.materials.show')->with('viewData', $viewData);
    }
}
