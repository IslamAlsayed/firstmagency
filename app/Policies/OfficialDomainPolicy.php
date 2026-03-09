<?php

namespace App\Policies;

use App\Models\OfficialDomain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficialDomainPolicy
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
        return $user->can('official-domains-read');
    }

    public function view(User $user, OfficialDomain $officialDomain): bool
    {
        return $user->can('official-domains-read');
    }

    public function create(User $user): bool
    {
        return $user->can('official-domains-create');
    }

    public function update(User $user, OfficialDomain $officialDomain): bool
    {
        return $user->can('official-domains-update');
    }

    public function delete(User $user, OfficialDomain $officialDomain): bool
    {
        return $user->can('official-domains-delete');
    }

    public function restore(User $user, OfficialDomain $officialDomain): bool
    {
        return $user->can('official-domains-restore');
    }

    public function forceDelete(User $user, OfficialDomain $officialDomain): bool
    {
        return $user->can('official-domains-force-delete');
    }
}
