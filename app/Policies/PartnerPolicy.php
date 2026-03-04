<?php

namespace App\Policies;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
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
        return $user->can('partners-read');
    }

    public function view(User $user, Partner $partner): bool
    {
        return $user->can('partners-read');
    }

    public function create(User $user): bool
    {
        return $user->can('partners-create');
    }

    public function update(User $user, Partner $partner): bool
    {
        return $user->can('partners-update');
    }

    public function delete(User $user, Partner $partner): bool
    {
        return $user->can('partners-delete');
    }

    public function restore(User $user, Partner $partner): bool
    {
        return $user->can('partners-restore');
    }

    public function forceDelete(User $user, Partner $partner): bool
    {
        return $user->can('partners-force-delete');
    }
}
