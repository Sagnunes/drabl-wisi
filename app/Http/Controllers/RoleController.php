<?php

namespace App\Http\Controllers;

use App\DTOs\RoleDTO;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use App\Services\UserRoleService;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct(private readonly RoleService $roleService)
    {
    }

    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index()
    {
        return Inertia::render('roles/Index', ['roles' => $this->roleService->getAllRoles()]);
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
    public function store(StoreRoleRequest $request)
    {
        $this->roleService->createRole((RoleDTO::fromRequest($request->validated())));
        $request->session()->flash('toast', [
            'title' => 'Success',
            'message' => 'Role created successfully!',
            'type' => 'success'
        ]);
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     * @throws \Exception
     */
    public function show(Role $role)
    {
        return Inertia::render('roles/Show', ['role' => $this->roleService->getRole($role->id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->updateRole($role, RoleDTO::fromRequest($request->validated()));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $this->roleService->deleteRole($role);
        return redirect()->route('roles.index');
    }
}
