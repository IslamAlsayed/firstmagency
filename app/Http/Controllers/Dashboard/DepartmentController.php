<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Mail\TicketAssignedDepartmentMail;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Support\SafeMail;
use App\Traits\AblyService;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;

class DepartmentController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait, AblyService;

    protected $modelClass = Department::class;

    public function index()
    {
        $this->authorize('viewAny', Department::class);
        $departments = Department::with(['user'])->latest()->paginate(15);
        return view('dashboard.departments.index', compact('departments'));
    }

    public function create()
    {
        $this->authorize('create', Department::class);
        $users = User::get(['id', 'name', 'email', 'role']);
        return view('dashboard.departments.create', compact('users'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Department::class);
        $department = Department::create(array_merge($request->validated(), ['name' => str_replace(' ', '-', str_replace('_', '-', strtolower($request->name)))]));
        return $department
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.department')]))
                : redirect()->route('dashboard.departments.index')->withSuccess(__('messages.type_created', ['type' => __('main.department')])))
            : redirect()->route('dashboard.departments.index')->withError(__('messages.type_creation_failed', ['type' => __('main.department')]));
    }

    public function show($id)
    {
        $department = Department::find($id);
        if (!$department)
            return redirect()->route('dashboard.departments.index')->withError(__('messages.type_not_found', ['type' => __('main.department')]));
        $this->authorize('view', $department);
        return view('dashboard.departments.show', compact('department'));
    }

    public function edit($id)
    {
        $department = Department::find($id);
        if (!$department)
            return redirect()->route('dashboard.departments.index')->withError(__('messages.type_not_found', ['type' => __('main.department')]));
        $this->authorize('update', $department);
        $users = User::get(['id', 'name', 'email', 'role']);
        return view('dashboard.departments.edit', compact('department', 'users'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $department = Department::find($id);
        if (!$department)
            return redirect()->route('dashboard.departments.index')->withError(__('messages.type_not_found', ['type' => __('main.department')]));
        $this->authorize('update', $department);
        $updated = $department->update(array_merge($request->validated(), ['name' => str_replace(' ', '-', str_replace('_', '-', strtolower($request->name)))]));

        return $updated
            ? redirect()->route('dashboard.departments.index')->withSuccess(__('messages.type_updated', ['type' => __('main.department')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.department')]));
    }

    /**
     * Toggle active status for a single department
     */
    public function toggleActive(Department $department)
    {
        $this->authorize('update', $department);
        $department->update(['is_active' => !$department->is_active]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $department->is_active
            ]);
        }

        return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.department')]));
    }

    /**
     * Bulk toggle active status for multiple departments
     */
    public function bulkToggleActive()
    {
        $this->authorize('update', Department::class);

        $ids = request()->input('ids', []);
        $status = request()->input('status', true);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No departments selected'], 400);
        }

        Department::whereIn('id', $ids)->update(['is_active' => $status]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.type_updated', ['type' => __('main.department')])
            ]);
        }

        return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.department')]));
    }

    /**
     * Change ticket department
     */
    public function changeTicketDepartment($department, $ticketId)
    {
        $ticketModel = Ticket::find($ticketId);

        if (!$ticketModel) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Ticket not found'], 404);
            }
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        }

        $this->authorize('update', $ticketModel);

        // Get the old department for comparison
        $oldDepartmentId = $ticketModel->department_id;

        // $department is the ID passed from route
        $ticketModel->update(['department_id' => $department]);

        // Get the new department details
        $newDepartment = Department::find($department);
        $departmentName = $newDepartment ? $newDepartment->name : __('main.no_department');

        // Get the user associated with the department
        if ($newDepartment && $newDepartment->user) {
            // Send email to the department user
            SafeMail::send($newDepartment->user->email, new TicketAssignedDepartmentMail($ticketModel, $newDepartment), [
                'source' => __CLASS__ . '@changeTicketDepartment',
                'ticket_id' => $ticketModel->id,
                'department_id' => $newDepartment->id,
            ]);
        }

        // Publish update to Ably channel with department data
        $this->publishToAbly('ticket-updates', 'ticket-status-updated', [
            'ticket_id' => $ticketModel->id,
            'uuid' => $ticketModel->uuid,
            'field' => 'department.id',
            'old_value' => $oldDepartmentId,
            'new_value' => $department,
            'status_label' => __('main.' . str_replace('-', '_', str_replace(' ', '_', $departmentName)), [], getActiveUser()->website_locale),
            'department' => $newDepartment ? [
                'id' => $newDepartment->id,
                'name' => $newDepartment->name,
                'bg_color' => $newDepartment->border_main_color,
            ] : null,
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.type_updated', ['type' => __('main.department')])
            ]);
        }

        return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.department')]));
    }
}
