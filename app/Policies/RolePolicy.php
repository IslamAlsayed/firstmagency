<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('roles-read');
    }

    public function view(User $user, Role $model): bool
    {
        return $user->can('roles-read');
    }

    public function create(User $user): bool
    {
        return $user->can('roles-create');
    }

    public function update(User $user, Role $model): bool
    {
        return $user->can('roles-update');
    }

    public function delete(User $user, Role $model): bool
    {
        return $user->can('roles-delete');
    }

    public function restore(User $user, Role $model): bool
    {
        return $user->can('roles-restore');
    }

    public function forceDelete(User $user, Role $model): bool
    {
        return $user->can('roles-force-delete');
    }
}
