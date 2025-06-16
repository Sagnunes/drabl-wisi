<?php

namespace App\Http\Controllers;

use App\DTOs\StatusDTO;
use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Services\StatusService;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function __construct(private readonly StatusService $statusService)
    {
    }

    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index()
    {
        return Inertia::render('status/index', ['status' => $this->statusService->getAllStatus()]);
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
     */
    public function store(StoreStatusRequest $request)
    {
        $this->statusService->createStatus((StatusDTO::fromRequest($request->validated())));
        return redirect()->route('status.index');
    }

    /**
     * Display the specified resource.
     * @throws \Exception
     */
    public function show(Status $status)
    {
        return Inertia::render('status/Show', ['status' => $this->statusService->getStatus($status->id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $this->statusService->updateStatus($status, StatusDTO::fromRequest($request->validated()));
        return redirect()->route('status.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $this->statusService->deleteStatus($status);
        return redirect()->route('status.index');
    }
}
