<?php

namespace App\Policies;

use App\Models\AboutUs;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AboutUsPolicy
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
        return $user->can('about-us-read');
    }

    public function view(User $user, AboutUs $aboutUs): bool
    {
        return $user->can('about-us-read');
    }

    public function create(User $user): bool
    {
        return $user->can('about-us-create');
    }

    public function update(User $user, AboutUs $aboutUs): bool
    {
        return $user->can('about-us-update');
    }

    public function delete(User $user, AboutUs $aboutUs): bool
    {
        return $user->can('about-us-delete');
    }

    public function restore(User $user, AboutUs $aboutUs): bool
    {
        return $user->can('about-us-restore');
    }

    public function forceDelete(User $user, AboutUs $aboutUs): bool
    {
        return $user->can('about-us-force-delete');
    }
}
