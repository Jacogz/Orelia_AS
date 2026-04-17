<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\View\View;
use \Exception;

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

            return view('user.materials.index')->with('viewData', $viewData);
        } catch (Exception $e) {
            $viewData = [];
            $viewData['title'] = __('materials.title');
            $viewData['materials'] = collect();

            return view('user.materials.index')->with('viewData', $viewData);
        }
    }
}
