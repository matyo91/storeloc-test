<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchStoresRequest;
use App\Models\Service;
use App\Services\StoreLocatorService;
use Illuminate\Http\Request;

class StorelocController extends Controller
{
    public function __construct(
        private StoreLocatorService $storeLocatorService
    ) {}

    public function index()
    {
        return view('index', [
            'services' => Service::orderBy('name')->get(),
        ]);
    }

    public function results(SearchStoresRequest $request)
    {
        $bounds = [
            'n' => (float) $request->input('n'),
            's' => (float) $request->input('s'),
            'e' => (float) $request->input('e'),
            'w' => (float) $request->input('w'),
        ];

        $serviceIds = $request->input('services', []);
        $operator = $request->input('operator', 'OR');

        $stores = $this->storeLocatorService->searchStores($bounds, $serviceIds, $operator);

        return view('results', [
            'stores' => $stores,
            'bounds' => $bounds,
            'selectedServices' => $serviceIds,
            'operator' => $operator,
            'services' => Service::orderBy('name')->get(),
        ]);
    }

    public function show(int $id)
    {
        $store = $this->storeLocatorService->getStore($id);

        return view('store', [
            'store' => $store,
        ]);
    }
}
