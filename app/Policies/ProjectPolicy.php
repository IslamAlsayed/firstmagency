<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
        return $user->can('projects-read');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->can('projects-read');
    }

    public function create(User $user): bool
    {
        return $user->can('projects-create');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->can('projects-update');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->can('projects-delete');
    }

    public function restore(User $user, Project $project): bool
    {
        return $user->can('projects-restore');
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->can('projects-force-delete');
    }
}
