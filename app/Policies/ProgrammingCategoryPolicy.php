<?php

namespace App\Policies;

use App\Models\ProgrammingCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgrammingCategoryPolicy
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
        return $user->can('programming-categories-read');
    }

    public function view(User $user, ProgrammingCategory $programmingCategory): bool
    {
        return $user->can('programming-categories-read');
    }

    public function create(User $user): bool
    {
        return $user->can('programming-categories-create');
    }

    public function update(User $user, ProgrammingCategory $programmingCategory): bool
    {
        return $user->can('programming-categories-update');
    }

    public function delete(User $user, ProgrammingCategory $programmingCategory): bool
    {
        return $user->can('programming-categories-delete');
    }

    public function restore(User $user, ProgrammingCategory $programmingCategory): bool
    {
        return $user->can('programming-categories-restore');
    }

    public function forceDelete(User $user, ProgrammingCategory $programmingCategory): bool
    {
        return $user->can('programming-categories-force-delete');
    }
}