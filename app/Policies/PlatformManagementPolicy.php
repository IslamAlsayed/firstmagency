<?php

namespace App\Policies;

use App\Models\PlatformManagement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformManagementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('platform-management-read');
    }

    public function view(User $user, PlatformManagement $platformManagement): bool
    {
        return $user->can('platform-management-read');
    }

    public function create(User $user): bool
    {
        return $user->can('platform-management-create');
    }

    public function update(User $user, PlatformManagement $platformManagement): bool
    {
        return $user->can('platform-management-update');
    }

    public function delete(User $user, PlatformManagement $platformManagement): bool
    {
        return $user->can('platform-management-delete');
    }

    public function restore(User $user, PlatformManagement $platformManagement): bool
    {
        return $user->can('platform-management-delete');
    }

    public function forceDelete(User $user, PlatformManagement $platformManagement): bool
    {
        return $user->can('platform-management-delete');
    }
}
