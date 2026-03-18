<?php

namespace App\Policies;

use App\Models\ProgrammingSystem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgrammingSystemPolicy
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
        return $user->can('programming-systems-read');
    }

    public function view(User $user, ProgrammingSystem $programmingSystem): bool
    {
        return $user->can('programming-systems-read');
    }

    public function create(User $user): bool
    {
        return $user->can('programming-systems-create');
    }

    public function update(User $user, ProgrammingSystem $programmingSystem): bool
    {
        return $user->can('programming-systems-update');
    }

    public function delete(User $user, ProgrammingSystem $programmingSystem): bool
    {
        return $user->can('programming-systems-delete');
    }

    public function restore(User $user, ProgrammingSystem $programmingSystem): bool
    {
        return $user->can('programming-systems-restore');
    }

    public function forceDelete(User $user, ProgrammingSystem $programmingSystem): bool
    {
        return $user->can('programming-systems-force-delete');
    }
}
