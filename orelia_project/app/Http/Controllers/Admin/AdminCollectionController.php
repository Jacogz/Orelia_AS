<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
USE App\Models\Collection;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    public function store(Request $request): View|RedirectResponse
    {

    }

    public function edit(string $id): View
    {
        return view('collections.admin.edit');
    }

    public function update(Request $request, string $id): View|RedirectResponse
    {

    }
}