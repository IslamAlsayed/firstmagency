<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Services\RoleRequestService;
use Modules\Core\Entities\RoleRequest;

class RoleRequestController extends Controller
{
    public function __construct(protected RoleRequestService $service) {}

    public function index()
    {
        $this->authorize('viewAny', RoleRequest::class);
        return view('dashboard.role-requests.index');
    }

    public function approved(RoleRequest $roleRequest)
    {
        $this->authorize('approve', $roleRequest);
        $this->service->approved($roleRequest);
        return redirect()->back()->withSuccess(__('messages.role_request_approved'));
    }

    public function rejected(Request $request, RoleRequest $roleRequest)
    {
        $this->authorize('reject', $roleRequest);
        $this->service->rejected($request->reason, $roleRequest);
        return redirect()->back()->withSuccess(__('messages.role_request_rejected'));
    }
}
