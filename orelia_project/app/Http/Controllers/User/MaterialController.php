<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        try {
            $materials = Material::all();
            $viewData = [];
            $viewData['title'] = __('materials.title');
            $viewData['subtitle'] = __('materials.subtitle');
            $viewData['materials'] = $materials;

            return view('materials.user.index', ['viewData' => $viewData]);
        } catch (\Exception $e) {
            $viewData = [];
            $viewData['title'] = __('materials.title');
            $viewData['materials'] = collect();

            return view('materials.user.index', ['viewData' => $viewData]);
        }
    }
}