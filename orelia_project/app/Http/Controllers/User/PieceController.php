<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PieceController extends Controller
{
    public function index(): View
    {
        return view('pieces.user.index');
    }
}
