<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        return view('collections.user.index');
    }
}
