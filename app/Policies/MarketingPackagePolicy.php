<?php

namespace App\Policies;

use App\Models\MarketingPackage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarketingPackagePolicy
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
        return $user->can('marketing-packages-read');
    }

    public function view(User $user, MarketingPackage $marketingPackage): bool
    {
        return $user->can('marketing-packages-read');
    }

    public function create(User $user): bool
    {
        return $user->can('marketing-packages-create');
    }

    public function update(User $user, MarketingPackage $marketingPackage): bool
    {
        return $user->can('marketing-packages-update');
    }

    public function delete(User $user, MarketingPackage $marketingPackage): bool
    {
        return $user->can('marketing-packages-delete');
    }

    public function restore(User $user, MarketingPackage $marketingPackage): bool
    {
        return $user->can('marketing-packages-restore');
    }

    public function forceDelete(User $user, MarketingPackage $marketingPackage): bool
    {
        return $user->can('marketing-packages-force-delete');
    }
}