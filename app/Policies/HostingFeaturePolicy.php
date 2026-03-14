<?php

namespace App\Policies;

use App\Models\HostingFeature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostingFeaturePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('hosting-features-read');
    }

    public function view(User $user, HostingFeature $hostingFeatures): bool
    {
        return $user->can('hosting-features-read');
    }

    public function create(User $user): bool
    {
        return $user->can('hosting-features-create');
    }

    public function update(User $user, HostingFeature $hostingFeatures): bool
    {
        return $user->can('hosting-features-update');
    }

    public function delete(User $user, HostingFeature $hostingFeatures): bool
    {
        return $user->can('hosting-features-delete');
    }

    public function restore(User $user, HostingFeature $hostingFeatures): bool
    {
        return $user->can('hosting-features-restore');
    }

    public function forceDelete(User $user, HostingFeature $hostingFeatures): bool
    {
        return $user->can('hosting-features-force-delete');
    }
}
