<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketStatus
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class TicketStatus extends Model
{
    protected $table = 'ticket_statuses';
    public $timestamps = false;

    public const OPEN = 1;
    public const ASSIGNED = 2;
    public const IN_PROGRESS = 3;
    public const ON_HOLD = 4;
    public const ESCALATED = 5;
    public const PENDING_CUSTOMER_RESPONSE = 6;
    public const RESOLVED = 7;
    public const CLOSED = 8;

    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the tickets for the TicketStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_statuses_id');
    }
}
