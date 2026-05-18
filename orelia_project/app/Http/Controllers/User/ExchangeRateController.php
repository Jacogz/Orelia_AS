<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ExchangeRateService;
use Illuminate\View\View;

class ExchangeRateController extends Controller
{
    private ExchangeRateService $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('exchangerate.title');
        $viewData['rates'] = $this->exchangeRateService->getRates();

        return view('user.exchangerate.index')->with('viewData', $viewData);
    }
}
