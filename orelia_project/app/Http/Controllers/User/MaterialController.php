<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        return view('materials.user.index');
    }
}
