<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
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
        return $user->can('services-read');
    }

    public function view(User $user, Service $service): bool
    {
        return $user->can('services-read');
    }

    public function create(User $user): bool
    {
        return $user->can('services-create');
    }

    public function update(User $user, Service $service): bool
    {
        return $user->can('services-update');
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->can('services-delete');
    }

    public function restore(User $user, Service $service): bool
    {
        return $user->can('services-restore');
    }

    public function forceDelete(User $user, Service $service): bool
    {
        return $user->can('services-force-delete');
    }
}
