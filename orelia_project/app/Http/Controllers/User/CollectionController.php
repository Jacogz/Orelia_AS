<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $collections = Collection::all();
        return view('collections.user.index', ['collections' => $collections]);
    }
}