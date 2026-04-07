<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::all();

        return view('materials.user.index', ['materials' => $materials]);
    }
}
