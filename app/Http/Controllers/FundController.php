<?php

namespace App\Http\Controllers;

use App\DTOs\FundDTO;
use App\Http\Requests\Funds\StoreFundRequest;
use App\Http\Requests\Funds\UpdateFundRequest;
use App\Models\Fund;
use App\Services\FundService;
use Inertia\Inertia;

class FundController extends Controller
{

    public function __construct(private readonly FundService $fundService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('funds/Index', ['funds' => $this->fundService->getAllFunds()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreFundRequest $request)
    {
        $this->fundService->createFund((FundDTO::fromRequest($request->validated())));
        return redirect()->route('funds.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        return Inertia::render('status/Show', ['status' => $this->fundService->getFund($fund->id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateFundRequest $request, Fund $fund)
    {
        $this->fundService->updateFund($fund, FundDTO::fromRequest($request->validated()));
        return redirect()->route('funds.index');
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(Fund $fund)
    {
        $this->fundService->deleteFund($fund);
        return redirect()->route('funds.index');
    }
}
