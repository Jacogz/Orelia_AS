<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (! in_array($locale, ['en', 'es'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
