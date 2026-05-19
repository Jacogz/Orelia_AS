<?php

namespace App\Http\Controllers\Admin;

use App\Filters\MaterialFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Material\StoreMaterialRequest;
use App\Http\Requests\Admin\Material\UpdateMaterialRequest;
use App\Models\Material;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMaterialController extends Controller
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
        $viewData['materials'] = $materials;
        $viewData['types'] = $types;

        return view('admin.materials.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('materials.create_title');

        return view('admin.materials.create')->with('viewData', $viewData);
    }

    public function store(StoreMaterialRequest $request): RedirectResponse
    {
        $validationData = $request->validated();

        $material = new Material;
        $material->fill($validationData);
        $material->save();

        return redirect()->route('admin.materials.index')
            ->with('success', __('materials.created'));
    }

    public function edit(string $id): View
    {
        $material = Material::findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('materials.edit_title');
        $viewData['material'] = $material;

        return view('admin.materials.edit')->with('viewData', $viewData);
    }

    public function update(UpdateMaterialRequest $request, string $id): RedirectResponse
    {
        $validationData = $request->validated();

        $material = Material::findOrFail($id);
        $material->fill($validationData);
        $material->save();

        return redirect()->route('admin.materials.index')
            ->with('success', __('materials.updated'));
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $material = Material::findOrFail($id);
            $material->delete();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', __('materials.error'));
        }

        return redirect()->route('admin.materials.index')
            ->with('success', __('materials.deleted'));
    }
}
