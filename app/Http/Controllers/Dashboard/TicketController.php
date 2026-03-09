<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    public function index()
    {
        $this->authorize('viewAny', Ticket::class);
        $tickets = Ticket::with(['user', 'assignedTo'])->latest()->paginate(15);
        return view('dashboard.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);
        $users = User::whereIn('role', ['superadmin', 'admin', 'support'])->get();

        $a = rand(1, 9);
        $b = rand(1, 9);
        session(['ticket_verification' => $a + $b]);
        return view('dashboard.tickets.create', compact('users', 'a', 'b'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Ticket::class);
        $validated = $request->validated();
        unset($validated['verification'], $validated['attachments']);
        $validated['user_id'] = Auth::id();
        $ticket = Ticket::create($validated);

        // upload new attachments
        if ($request->hasFile('attachments')) {
            $this->uploadFiles($request, $ticket, 'attachments', 'tickets');
        }

        session()->forget('ticket_verification');
        return redirect()->route('dashboard.tickets.index')->withSuccess(__('messages.type_created_successfully', ['type' => __('main.ticket')]));
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load(['user', 'assignedTo']);
        return view('dashboard.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $users = User::get(['id', 'name', 'role']);
        return view('dashboard.tickets.edit', compact('ticket', 'users'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        $this->authorize('update', $ticket);

        $validated = $request->validated();
        unset($validated['attachments'], $validated['removed_attachments']);
        $ticket->update($validated);

        // upload new attachments
        if ($request->hasFile('attachments')) {
            $this->uploadFiles($request, $ticket, 'attachments', 'tickets');
        }

        // remove selected files
        if ($request->filled('removed_attachments')) {
            $removedIndexes = json_decode($request->removed_attachments, true);
            $this->deleteFiles($ticket, $removedIndexes, 'attachments');
        }

        return redirect()->route('dashboard.tickets.index')->withSuccess(__('messages.type_updated_successfully', ['type' => __('main.ticket')]));
    }
}