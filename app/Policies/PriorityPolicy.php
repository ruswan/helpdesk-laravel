<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Priority;
use App\Models\User;

class PriorityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Priority');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Priority $priority): bool
    {
        return $user->can('view Priority');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Priority');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Priority $priority): bool
    {
        return $user->can('update Priority');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Priority $priority): bool
    {
        return $user->can('delete Priority');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Priority $priority): bool
    {
        return $user->can('restore Priority');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Priority $priority): bool
    {
        return $user->can('force-delete Priority');
    }
}
