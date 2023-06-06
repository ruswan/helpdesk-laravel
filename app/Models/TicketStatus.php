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

	protected $fillable = [
		'name'
	];

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'ticket_statuses_id');
	}
}
