<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Exception;
use Illuminate\View\View;

class PieceController extends Controller
{
    public function index(): View
    {
        // Sobran por no escribir en db
        try {
            $pieces = Piece::with('collection')->get();
            $viewData = [];
            $viewData['title'] = __('pieces.title');
            $viewData['subtitle'] = __('pieces.subtitle');
            $viewData['pieces'] = $pieces;

            return view('user.pieces.index')->with('viewData', $viewData);
        } catch (Exception $e) {
            $viewData = [];
            $viewData['title'] = __('pieces.title');
            $viewData['pieces'] = collect();

            return view('user.pieces.index')->with('viewData', $viewData);
        }
    }

    public function show(string $id): View
    {
        try {
            $piece = Piece::with('collection', 'materials')->findOrFail($id);
            $viewData = [];
            $viewData['title'] = $piece->getName();
            $viewData['piece'] = $piece;

            return view('user.pieces.show')->with('viewData', $viewData);
        } catch (Exception $e) {
            $viewData = [];
            $viewData['title'] = __('pieces.title');
            $viewData['piece'] = null;

            return view('user.pieces.show')->with('viewData', $viewData);
        }
    }
}
