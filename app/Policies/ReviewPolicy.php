<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
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
        return $user->can('reviews-read');
    }

    public function view(User $user, Review $reviews): bool
    {
        return $user->can('reviews-read');
    }

    public function create(User $user): bool
    {
        return $user->can('reviews-create');
    }

    public function update(User $user, Review $reviews): bool
    {
        return $user->can('reviews-update');
    }

    public function delete(User $user, Review $reviews): bool
    {
        return $user->can('reviews-delete');
    }

    public function restore(User $user, Review $reviews): bool
    {
        return $user->can('reviews-restore');
    }

    public function forceDelete(User $user, Review $reviews): bool
    {
        return $user->can('reviews-force-delete');
    }
}
