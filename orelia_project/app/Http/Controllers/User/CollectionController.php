<?php

namespace App\Http\Controllers\User;

use App\Filters\CollectionFilter;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    private ExchangeRateService $exchangeRateService;

    private CollectionFilter $collectionFilter;

    public function __construct(
        ExchangeRateService $exchangeRateService,
        CollectionFilter $collectionFilter
    ) {
        $this->exchangeRateService = $exchangeRateService;
        $this->collectionFilter = $collectionFilter;
    }

    public function index(Request $request): View
    {
        $query = Collection::query();
        $this->collectionFilter->apply($query, $request);

        $viewData = [];
        $viewData['title'] = __('collections.title');
        $viewData['subtitle'] = __('collections.subtitle');
        $viewData['collections'] = $query->get();

        return view('user.collections.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $collection = Collection::with('pieces')->findOrFail($id);

        $viewData = [];
        $viewData['title'] = $collection->getName();
        $viewData['collection'] = $collection;
        $viewData['pieces'] = $collection->getPieces();
        $viewData['rates'] = $this->exchangeRateService->getRates();

        return view('user.collections.show')->with('viewData', $viewData);
    }
}
