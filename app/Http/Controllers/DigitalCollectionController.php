<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Services\DigitalCollectionService;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class DigitalCollectionController extends Controller
{
    public function __construct(
        private readonly DigitalCollectionService $digitalCollectionService,
    )
    {
    }

    public function index()
    {
        return Inertia::render('digital-collection/Index', ['fundWithDigitalObject' => $this->digitalCollectionService->getDigitalCollectionFunds()]);

    }

    public function show(Fund $fund){

        $search = Request::input('search');

        $fundResourcesPagination = $this->digitalCollectionService->getDigitalObjectsByFund($fund, $search);

        return Inertia::render('digital-collection/Show', [
            'fund' => $fund,
            'collections' => Inertia::merge($fundResourcesPagination->items()),
            'pagination' => Arr::except($fundResourcesPagination->toArray(), ['data'])
        ]);
    }
}
