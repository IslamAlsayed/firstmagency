<?php

namespace App\Policies;

use App\Models\DashboardsAndSystem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardsAndSystemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('dashboards-and-systems-read');
    }

    public function view(User $user, DashboardsAndSystem $dashboardsAndSystem): bool
    {
        return $user->can('dashboards-and-systems-read');
    }

    public function create(User $user): bool
    {
        return $user->can('dashboards-and-systems-create');
    }

    public function update(User $user, DashboardsAndSystem $dashboardsAndSystem): bool
    {
        return $user->can('dashboards-and-systems-update');
    }

    public function delete(User $user, DashboardsAndSystem $dashboardsAndSystem): bool
    {
        return $user->can('dashboards-and-systems-delete');
    }

    public function restore(User $user, DashboardsAndSystem $dashboardsAndSystem): bool
    {
        return $user->can('dashboards-and-systems-restore');
    }

    public function forceDelete(User $user, DashboardsAndSystem $dashboardsAndSystem): bool
    {
        return $user->can('dashboards-and-systems-force-delete');
    }
}
