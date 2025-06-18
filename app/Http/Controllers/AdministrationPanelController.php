<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleRequest;
use App\Http\Requests\RemoveRoleRequest;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Services\AdministrationPanelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

/**
 * Class AdministrationPanelController
 *
 * Controller for handling administration panel operations.
 */
class AdministrationPanelController extends Controller
{
    /**
     * AdministrationPanelController constructor.
     *
     * @param AdministrationPanelService $administrationPanelService Service for administration panel operations
     */
    public function __construct(
        private readonly AdministrationPanelService $administrationPanelService,
    )
    {
    }

    /**
     * Display a listing of users in the administration panel.
     *
     * @return Response The Inertia response with users data
     */
    public function index(): Response
    {
        try {
            return Inertia::render('admin-panel/Index',
                [
                    'users' => $this->administrationPanelService->allUserWithRelations(),
                    'roles' => $this->administrationPanelService->getAllRoles()
                ]
            );
        } catch (Throwable $e) {
            // Log the exception
            report($e);

            // Return an Inertia response with an error message
            return Inertia::render('admin-panel/Index',
                [
                    'users' => [],
                    'roles' => [],
                    'error' => 'An error occurred while loading the administration panel: ' . $e->getMessage()
                ]
            );
        }
    }

    /**
     * Update the status of a user.
     *
     * @param UpdateUserStatusRequest $request The validated request
     * @return RedirectResponse Redirect back with success or error message
     */
    public function updateStatus(UpdateUserStatusRequest $request): RedirectResponse
    {
        try {
            // Get the validated status from the request
            $newStatus = $request->getValidatedStatus();

            // Check if the status is valid
            if (!$newStatus) {
                return redirect()->back()->with('error', 'Invalid status provided');
            }

            // Get the validated user ID
            $userId = $request->validated('user_id');

            // Update the user status
            $this->administrationPanelService->setUserStatus($userId, $newStatus);

            return redirect()->back()->with('success', 'Status updated successfully');
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (ModelNotFoundException $e) {
            // Handle case where user is not found
            return redirect()->back()->with('error', 'User not found');
        } catch (Throwable $e) {
            // Handle any other exceptions
            report($e); // Log the exception
            return redirect()->back()->with('error', 'An error occurred while updating the status: ' . $e->getMessage());
        }
    }

    /**
     * Assign roles to a user.
     *
     * @param AssignRoleRequest $request The validated request containing user_id and roles
     * @return RedirectResponse Redirect back with success or error message
     */
    public function assignRole(AssignRoleRequest $request): RedirectResponse
    {
        try {
            $userId = $request->getUserId();
            $roles = $request->getRoles();

            foreach ($roles as $roleId) {
                $this->administrationPanelService->assignRoleById($userId, $roleId);
            }

            return redirect()->back()->with('success', 'Roles assigned successfully');
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (ModelNotFoundException $e) {
            // Handle case where user is not found
            return redirect()->back()->with('error', 'User not found');
        } catch (Throwable $e) {
            // Handle any other exceptions
            report($e); // Log the exception
            return redirect()->back()->with('error', 'An error occurred while assigning roles: ' . $e->getMessage());
        }
    }

    /**
     * Remove roles from a user.
     *
     * @param RemoveRoleRequest $request The validated request containing user_id and roles
     * @return RedirectResponse Redirect back with success or error message
     */
    public function removeRole(RemoveRoleRequest $request): RedirectResponse
    {
        try {
            $userId = $request->getUserId();
            $roles = $request->getRoles();

            foreach ($roles as $roleId) {
                $this->administrationPanelService->removeRoleById($userId, $roleId);
            }

            return redirect()->back()->with('success', 'Roles removed successfully');
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (ModelNotFoundException $e) {
            // Handle case where user is not found
            return redirect()->back()->with('error', 'User not found');
        } catch (Throwable $e) {
            // Handle any other exceptions
            report($e); // Log the exception
            return redirect()->back()->with('error', 'An error occurred while removing roles: ' . $e->getMessage());
        }
    }
}
