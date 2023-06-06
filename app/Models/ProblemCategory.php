<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProblemCategory
 * 
 * @property int $id
 * @property int $unit_id
 * @property string $name
 * 
 * @property Unit $unit
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class ProblemCategory extends Model
{
	protected $table = 'problem_categories';
	public $timestamps = false;

	protected $casts = [
		'unit_id' => 'int'
	];

	protected $fillable = [
		'unit_id',
		'name'
	];

	public function unit()
	{
		return $this->belongsTo(Unit::class);
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}
}
