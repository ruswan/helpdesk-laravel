<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPriorities extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public const CRITICAL = 1;
    public const HIGHT = 2;
    public const MEDIUM = 3;
    public const LOW = 4;
    public const ENHANCEMENT = 5;

    /**
     * Get all of the tickets for the TicketPriorities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
