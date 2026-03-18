<?php

namespace App\Policies;

use App\Models\HostingPackage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostingPackagePolicy
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
        return $user->can('hosting-packages-read');
    }

    public function view(User $user, HostingPackage $hostingPackage): bool
    {
        return $user->can('hosting-packages-read');
    }

    public function create(User $user): bool
    {
        return $user->can('hosting-packages-create');
    }

    public function update(User $user, HostingPackage $hostingPackage): bool
    {
        return $user->can('hosting-packages-update');
    }

    public function delete(User $user, HostingPackage $hostingPackage): bool
    {
        return $user->can('hosting-packages-delete');
    }

    public function restore(User $user, HostingPackage $hostingPackage): bool
    {
        return $user->can('hosting-packages-delete');
    }

    public function forceDelete(User $user, HostingPackage $hostingPackage): bool
    {
        return $user->can('hosting-packages-delete');
    }
}
