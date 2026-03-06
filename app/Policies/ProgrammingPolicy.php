<?php

namespace App\Policies;

use App\Models\Programming;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgrammingPolicy
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
        return $user->can('programmings-read');
    }

    public function view(User $user, Programming $programming): bool
    {
        return $user->can('programmings-read');
    }

    public function create(User $user): bool
    {
        return $user->can('programmings-create');
    }

    public function update(User $user, Programming $programming): bool
    {
        return $user->can('programmings-update');
    }

    public function delete(User $user, Programming $programming): bool
    {
        return $user->can('programmings-delete');
    }

    public function restore(User $user, Programming $programming): bool
    {
        return $user->can('programmings-restore');
    }

    public function forceDelete(User $user, Programming $programming): bool
    {
        return $user->can('programmings-force-delete');
    }
}
