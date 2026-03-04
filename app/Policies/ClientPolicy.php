<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
        return $user->can('clients-read');
    }

    public function view(User $user, Client $client): bool
    {
        return $user->can('clients-read');
    }

    public function create(User $user): bool
    {
        return $user->can('clients-create');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->can('clients-update');
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->can('clients-delete');
    }

    public function restore(User $user, Client $client): bool
    {
        return $user->can('clients-restore');
    }

    public function forceDelete(User $user, Client $client): bool
    {
        return $user->can('clients-force-delete');
    }
}
