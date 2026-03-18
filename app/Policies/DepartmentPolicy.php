<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
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
        return $user->can('departments-read');
    }

    public function view(User $user, Department $department): bool
    {
        return $user->can('departments-read');
    }

    public function create(User $user): bool
    {
        return $user->can('departments-create');
    }

    public function update(User $user, Department $department): bool
    {
        return $user->can('departments-update');
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->can('departments-delete');
    }

    public function restore(User $user, Department $department): bool
    {
        return $user->can('departments-restore');
    }

    public function forceDelete(User $user, Department $department): bool
    {
        return $user->can('departments-force-delete');
    }
}
