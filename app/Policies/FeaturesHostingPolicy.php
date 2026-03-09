<?php

namespace App\Policies;

use App\Models\FeaturesHosting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturesHostingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('features-hosting-read');
    }

    public function view(User $user, FeaturesHosting $featuresHosting): bool
    {
        return $user->can('features-hosting-read');
    }

    public function create(User $user): bool
    {
        return $user->can('features-hosting-create');
    }

    public function update(User $user, FeaturesHosting $featuresHosting): bool
    {
        return $user->can('features-hosting-update');
    }

    public function delete(User $user, FeaturesHosting $featuresHosting): bool
    {
        return $user->can('features-hosting-delete');
    }

    public function restore(User $user, FeaturesHosting $featuresHosting): bool
    {
        return $user->can('features-hosting-restore');
    }

    public function forceDelete(User $user, FeaturesHosting $featuresHosting): bool
    {
        return $user->can('features-hosting-force-delete');
    }
}
