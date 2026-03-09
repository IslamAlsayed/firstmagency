<?php

namespace App\Policies;

use App\Models\WhyUs;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WhyUsPolicy
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
        return $user->can('why-us-read');
    }

    public function view(User $user, WhyUs $whyUs): bool
    {
        return $user->can('why-us-read');
    }

    public function create(User $user): bool
    {
        return $user->can('why-us-create');
    }

    public function update(User $user, WhyUs $whyUs): bool
    {
        return $user->can('why-us-update');
    }

    public function delete(User $user, WhyUs $whyUs): bool
    {
        return $user->can('why-us-delete');
    }

    public function restore(User $user, WhyUs $whyUs): bool
    {
        return $user->can('why-us-restore');
    }

    public function forceDelete(User $user, WhyUs $whyUs): bool
    {
        return $user->can('why-us-force-delete');
    }
}
