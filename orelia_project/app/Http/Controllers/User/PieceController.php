<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Illuminate\View\View;

class PieceController extends Controller
{
    public function index(): View
    {
        $pieces = Piece::with('collection')->get();

        return view('pieces.user.index', ['pieces' => $pieces]);
    }
}
