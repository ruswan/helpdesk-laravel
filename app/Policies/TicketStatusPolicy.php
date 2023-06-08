<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TicketStatus;
use App\Models\User;

class TicketStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any TicketStatus');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('view TicketStatus');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create TicketStatus');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('update TicketStatus');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('delete TicketStatus');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('restore TicketStatus');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('force-delete TicketStatus');
    }
}
