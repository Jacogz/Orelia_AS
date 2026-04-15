<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Illuminate\View\View;

class PieceController extends Controller
{
    public function index(): View
    {
        try {
            $pieces = Piece::with('collection')->get();
            $viewData = [];
            $viewData['title'] = __('pieces.title');
            $viewData['subtitle'] = __('pieces.subtitle');
            $viewData['pieces'] = $pieces;

            return view('pieces.user.index', ['viewData' => $viewData]);
        } catch (\Exception $e) {
            $viewData = [];
            $viewData['title'] = __('pieces.title');
            $viewData['pieces'] = collect();

            return view('pieces.user.index', ['viewData' => $viewData]);
        }
    }

    public function show(string $id): View
    {
        try {
            $piece = Piece::with('collection', 'materials')->findOrFail($id);
            $viewData = [];
            $viewData['title'] = $piece->getName();
            $viewData['piece'] = $piece;

            return view('pieces.user.show', ['viewData' => $viewData]);
        } catch (\Exception $e) {
            $viewData = [];
            $viewData['title'] = __('pieces.title');
            $viewData['piece'] = null;

            return view('pieces.user.show', ['viewData' => $viewData]);
        }
    }
}
