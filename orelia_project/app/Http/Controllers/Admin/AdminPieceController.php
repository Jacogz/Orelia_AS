<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Piece;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminPieceController extends Controller
{
    public function index(): View
    {
        return view('pieces.admin.index');
    }

        public function create(): View
    {
        return view('pieces.admin.create');
    }

    public function store(Request $request): View|RedirectResponse
    {

    }

    public function edit(string $id): View
    {
        return view('pieces.admin.edit');
    }

    public function update(Request $request, string $id): View|RedirectResponse
    {

    }
}