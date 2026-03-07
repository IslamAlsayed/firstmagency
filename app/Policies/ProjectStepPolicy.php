<?php

namespace App\Policies;

use App\Models\ProjectStep;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectStepPolicy
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
        return $user->can('project-steps-read');
    }

    public function view(User $user, ProjectStep $projectStep): bool
    {
        return $user->can('project-steps-read');
    }

    public function create(User $user): bool
    {
        return $user->can('project-steps-create');
    }

    public function update(User $user, ProjectStep $projectStep): bool
    {
        return $user->can('project-steps-update');
    }

    public function delete(User $user, ProjectStep $projectStep): bool
    {
        return $user->can('project-steps-delete');
    }

    public function restore(User $user, ProjectStep $projectStep): bool
    {
        return $user->can('project-steps-restore');
    }

    public function forceDelete(User $user, ProjectStep $projectStep): bool
    {
        return $user->can('project-steps-force-delete');
    }
}
