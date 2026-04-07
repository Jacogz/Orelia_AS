<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Piece;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PieceController extends Controller
{
    public function index(): View
    {
        return view('pieces.user.index');
    }
}