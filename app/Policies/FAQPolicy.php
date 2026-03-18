<?php

namespace App\Policies;

use App\Models\FAQ;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FAQPolicy
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
        return $user->can('faqs-read');
    }

    public function view(User $user, FAQ $faq): bool
    {
        return $user->can('faqs-read');
    }

    public function create(User $user): bool
    {
        return $user->can('faqs-create');
    }

    public function update(User $user, FAQ $faq): bool
    {
        return $user->can('faqs-update');
    }

    public function delete(User $user, FAQ $faq): bool
    {
        return $user->can('faqs-delete');
    }

    public function restore(User $user, FAQ $faq): bool
    {
        return $user->can('faqs-restore');
    }

    public function forceDelete(User $user, FAQ $faq): bool
    {
        return $user->can('faqs-force-delete');
    }
}
