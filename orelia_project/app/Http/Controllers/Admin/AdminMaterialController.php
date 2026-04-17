<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::all();
        $viewData = [];
        $viewData['title'] = __('materials.title');
        $viewData['materials'] = $materials;

        return view('admin.materials.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('materials.create_title');

        return view('admin.materials.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validationData = Material::validate($request);
            $material = new Material;
            $material->fill($validationData);
            $material->save();

            return redirect()->route('admin.materials.index')
                ->with('success', __('materials.created'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('materials.error'));
        }
    }

    public function edit(string $id): View
    {
        $material = Material::findOrFail($id);
        $viewData = [];
        $viewData['title'] = __('materials.edit_title');
        $viewData['material'] = $material;

        return view('admin.materials.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        try {
            $material = Material::findOrFail($id);
            $validationData = Material::validate($request);
            $material->fill($validationData);
            $material->save();

            return redirect()->route('admin.materials.index')
                ->with('success', __('materials.updated'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('materials.error'));
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $material = Material::findOrFail($id);
            $material->delete();

            return redirect()->route('admin.materials.index')
                ->with('success', __('materials.deleted'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('materials.error'));
        }
    }
}
