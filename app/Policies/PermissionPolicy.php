<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('permissions-read');
    }

    public function view(User $user, Permission $model): bool
    {
        return $user->can('permissions-read');
    }

    public function create(User $user): bool
    {
        return $user->can('permissions-create');
    }

    public function update(User $user, Permission $model): bool
    {
        return $user->can('permissions-update');
    }

    public function delete(User $user, Permission $model): bool
    {
        return $user->can('permissions-delete');
    }

    public function restore(User $user, Permission $model): bool
    {
        return $user->can('permissions-restore');
    }

    public function forceDelete(User $user, Permission $model): bool
    {
        return $user->can('permissions-force-delete');
    }
}
