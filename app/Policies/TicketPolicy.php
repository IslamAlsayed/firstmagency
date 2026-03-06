<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): ?bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('tickets-read');
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets-read');
    }

    public function create(User $user): bool
    {
        return $user->can('tickets-create');
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets-update');
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets-delete');
    }

    public function restore(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets-restore');
    }

    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets-force-delete');
    }
}
