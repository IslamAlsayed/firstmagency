<?php

namespace App\Policies;

use App\Models\LineWork;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LineWorkPolicy
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
        return $user->can('line-works-read');
    }

    public function view(User $user, LineWork $lineWork): bool
    {
        return $user->can('line-works-read');
    }

    public function create(User $user): bool
    {
        return $user->can('line-works-create');
    }

    public function update(User $user, LineWork $lineWork): bool
    {
        return $user->can('line-works-update');
    }

    public function delete(User $user, LineWork $lineWork): bool
    {
        return $user->can('line-works-delete');
    }

    public function restore(User $user, LineWork $lineWork): bool
    {
        return $user->can('line-works-restore');
    }

    public function forceDelete(User $user, LineWork $lineWork): bool
    {
        return $user->can('line-works-force-delete');
    }
}
