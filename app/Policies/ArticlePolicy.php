<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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
        return $user->can('articles-read');
    }

    public function view(User $user, Article $article): bool
    {
        return $user->can('articles-read');
    }

    public function create(User $user): bool
    {
        return $user->can('articles-create');
    }

    public function update(User $user, Article $article): bool
    {
        return $user->can('articles-update');
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->can('articles-delete');
    }

    public function restore(User $user, Article $article): bool
    {
        return $user->can('articles-restore');
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return $user->can('articles-force-delete');
    }
}
