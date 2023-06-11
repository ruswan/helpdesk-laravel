<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // The admin unit can view tickets that are assigned to their specific unit.
        if ($user->hasRole('Admin Unit')) {
            return $user->id == $ticket->owner_id || $ticket->unit_id == $user->unit_id;
        }

        // The staff unit can view tickets that have been assigned to them.
        if ($user->hasRole('Staff Unit')) {
            return $user->id == $ticket->owner_id ||  $ticket->responsible_id == $user->id;
        }

        // The user can view their own ticket
        return $user->id == $ticket->owner_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        if ($ticket->ticket_statuses_id != TicketStatus::OPEN) {
            return false;
        }

        return $user->id == $ticket->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return $user->id == $ticket->owner_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return $user->id == $ticket->owner_id;
    }
}
