<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Illuminate\View\View;

class PieceController extends Controller
{
    public function index(): View
    {
        $Pieces = Piece::all();

        return view('pieces.user.index', ['Pieces' => $Pieces]);
    }
}
