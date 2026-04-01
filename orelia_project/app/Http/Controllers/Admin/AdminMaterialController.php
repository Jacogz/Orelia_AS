<?php

namespace App\Http\Controllers\Admin;

use Iluminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Http\Controllers\Controller;
use App\Models\Material;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminMaterialController extends Controller
{
    public function index(): View
    {
        return view('materials.admin.index');
    }

        public function create(): View
    {
        return view('materials.admin.create');
    }

    public function store(Request $request): View|RedirectResponse
    {

    }

    public function edit(string $id): View
    {
        return view('materials.admin.edit');
    }

    public function update(Request $request, string $id): View|RedirectResponse
    {

    }
}