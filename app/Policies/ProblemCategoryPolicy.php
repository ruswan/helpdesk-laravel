<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ProblemCategory;
use App\Models\User;

class ProblemCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any ProblemCategory');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProblemCategory $problemcategory): bool
    {
        return $user->can('view ProblemCategory');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create ProblemCategory');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProblemCategory $problemcategory): bool
    {
        return $user->can('update ProblemCategory');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProblemCategory $problemcategory): bool
    {
        return $user->can('delete ProblemCategory');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProblemCategory $problemcategory): bool
    {
        return $user->can('restore ProblemCategory');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProblemCategory $problemcategory): bool
    {
        return $user->can('force-delete ProblemCategory');
    }
}
