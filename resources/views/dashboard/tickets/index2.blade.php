@extends('dashboard.layout.master')

@section('title', __('main.tickets'))
@section('page-title', '🎫 ' . __('main.tickets'))

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ __('main.tickets') }}</h1>
            @can('create', App\Models\Ticket::class)
                <a href="{{ route('dashboard.tickets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('main.create_ticket') }}
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('main.title') }}</th>
                                <th>{{ __('main.status') }}</th>
                                <th>{{ __('main.priority') }}</th>
                                <th>{{ __('main.category') }}</th>
                                <th>{{ __('main.assigned_to') }}</th>
                                <th>{{ __('main.created_at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $ticket->status === 'open' ? 'primary' : ($ticket->status === 'in_progress' ? 'warning' : ($ticket->status === 'resolved' ? 'success' : 'secondary')) }}">
                                            {{ __('main.' . $ticket->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $ticket->priority === 'low' ? 'secondary' : ($ticket->priority === 'medium' ? 'info' : ($ticket->priority === 'high' ? 'warning' : 'danger')) }}">
                                            {{ __('main.' . $ticket->priority) }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->category ?? '-' }}</td>
                                    <td>{{ $ticket->assignedTo->name ?? '-' }}</td>
                                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view', $ticket)
                                                <a href="{{ route('dashboard.tickets.show', $ticket) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('update', $ticket)
                                                <a href="{{ route('dashboard.tickets.edit', $ticket) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $ticket)
                                                <form action="{{ route('dashboard.tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('main.confirm_delete') }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('main.no_tickets_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
