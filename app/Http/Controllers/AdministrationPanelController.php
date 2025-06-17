<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AdministrationPanelService;

;

use App\UserStatusEnum;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministrationPanelController extends Controller
{
    public function __construct(
        private readonly AdministrationPanelService $administrationPanelService,
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('admin-panel/Index',
            [
                'users' => $this->administrationPanelService->allUserWithRelations()
            ]
        );
    }

    public function updateStatus(Request $request)
    {
        if (!$request['user_id'] || !$request['updatedStatus']) {
            return redirect()->back();
        }

        $this->administrationPanelService->setUserStatus($request['user_id'], UserStatusEnum::fromName($request['updatedStatus']));

        return redirect()->back();

    }
}
