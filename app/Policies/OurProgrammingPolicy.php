<?php

namespace App\Policies;

use App\Models\OurProgramming;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OurProgrammingPolicy
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
        return $user->can('our-programmings-read');
    }

    public function view(User $user, OurProgramming $ourProgramming): bool
    {
        return $user->can('our-programmings-read');
    }

    public function create(User $user): bool
    {
        return $user->can('our-programmings-create');
    }

    public function update(User $user, OurProgramming $ourProgramming): bool
    {
        return $user->can('our-programmings-update');
    }

    public function delete(User $user, OurProgramming $ourProgramming): bool
    {
        return $user->can('our-programmings-delete');
    }

    public function restore(User $user, OurProgramming $ourProgramming): bool
    {
        return $user->can('our-programmings-restore');
    }

    public function forceDelete(User $user, OurProgramming $ourProgramming): bool
    {
        return $user->can('our-programmings-force-delete');
    }
}
