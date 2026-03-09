<?php

namespace App\Policies;

use App\Models\WorkUsStep;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkUsStepPolicy
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
        return $user->can('work-us-step-read');
    }

    public function view(User $user, WorkUsStep $workUsStep): bool
    {
        return $user->can('work-us-step-read');
    }

    public function create(User $user): bool
    {
        return $user->can('work-us-step-create');
    }

    public function update(User $user, WorkUsStep $workUsStep): bool
    {
        return $user->can('work-us-step-update');
    }

    public function delete(User $user, WorkUsStep $workUsStep): bool
    {
        return $user->can('work-us-step-delete');
    }

    public function restore(User $user, WorkUsStep $workUsStep): bool
    {
        return $user->can('work-us-step-restore');
    }

    public function forceDelete(User $user, WorkUsStep $workUsStep): bool
    {
        return $user->can('work-us-step-force-delete');
    }
}
