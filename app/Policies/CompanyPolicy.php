<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
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
        return $user->can('companies-read');
    }

    public function view(User $user, Company $company): bool
    {
        return $user->can('companies-read');
    }

    public function create(User $user): bool
    {
        return $user->can('companies-create');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->can('companies-update');
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->can('companies-delete');
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->can('companies-restore');
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $user->can('companies-force-delete');
    }
}
