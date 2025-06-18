<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\User;
use App\Services\AdministrationPanelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;
use Illuminate\Http\Request;

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
        return Inertia::render('admin-panel/Index',
            [
                'users' => $this->administrationPanelService->allUserWithRelations(),
                'roles' => $this->administrationPanelService->getAllRoles()
            ]
        );
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

    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request['user_id']);

        foreach ($request['roles'] as $role) {
            $this->administrationPanelService->assignRoleToUser($user, $role);
        }
        return redirect()->back();
    }

    public function revokeRole(Request $request)
    {
        $user = User::findOrFail($request['user_id']);

        foreach ($request['roles'] as $role) {
            $this->administrationPanelService->revokeRoleFromUser($user, $role);
        }
        return redirect()->back();
    }
}
