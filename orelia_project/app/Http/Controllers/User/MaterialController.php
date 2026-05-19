<?php

namespace App\Http\Controllers\User;

use App\Filters\MaterialFilter;
use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    private MaterialFilter $materialFilter;

    public function __construct(MaterialFilter $materialFilter)
    {
        $this->materialFilter = $materialFilter;
    }

    public function index(Request $request): View
    {
        $query = Material::query();
        $this->materialFilter->apply($query, $request);

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
