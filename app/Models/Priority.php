<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Priority
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Priority extends Model
{
	protected $table = 'priorities';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}
}
