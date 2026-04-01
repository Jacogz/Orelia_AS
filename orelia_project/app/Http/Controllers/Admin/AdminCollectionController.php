<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCollectionController extends Controller
{
    public function index(): View
    {
        return view('collections.admin.index');
    }

    public function create(): View
    {
        return view('collections.admin.create');
    }

    public function store(Request $request): View|RedirectResponse {}

    public function edit(string $id): View
    {
        return view('collections.admin.edit');
    }

    public function update(Request $request, string $id): View|RedirectResponse {}
}
