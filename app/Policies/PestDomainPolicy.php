<?php

namespace App\Policies;

use App\Models\PestDomain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PestDomainPolicy
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
        return $user->can('pest-domains-read');
    }

    public function view(User $user, PestDomain $pestDomain): bool
    {
        return $user->can('pest-domains-read');
    }

    public function create(User $user): bool
    {
        return $user->can('pest-domains-create');
    }

    public function update(User $user, PestDomain $pestDomain): bool
    {
        return $user->can('pest-domains-update');
    }

    public function delete(User $user, PestDomain $pestDomain): bool
    {
        return $user->can('pest-domains-delete');
    }

    public function restore(User $user, PestDomain $pestDomain): bool
    {
        return $user->can('pest-domains-restore');
    }

    public function forceDelete(User $user, PestDomain $pestDomain): bool
    {
        return $user->can('pest-domains-force-delete');
    }
}
