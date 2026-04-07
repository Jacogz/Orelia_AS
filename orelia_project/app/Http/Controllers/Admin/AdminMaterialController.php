<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::all();

        return view('materials.admin.index', ['materials' => $materials]);
    }

    public function create(): View
    {
        return view('materials.admin.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = Material::validate($request);
        Material::create($data);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material created successfully.');
    }

    public function edit(string $id): View
    {
        $material = Material::findOrFail($id);

        return view('materials.admin.edit', ['material' => $material]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $material = Material::findOrFail($id);
        $data = Material::validate($request);
        $material->update($data);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material deleted successfully.');
    }
}
