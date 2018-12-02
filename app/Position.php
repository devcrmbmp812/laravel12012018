<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

	/**
	 * @var  string
	 */
	protected $table = 'positions';

	protected $casts = [
	'updated_at' => 'datetime',
	];
 
	public function user()
	{
		return $this->hasMany('Vanguard\User', 'position_id', 'id');
	}


	public function supervisor()
	{
		return $this->hasMany('Vanguard\User', 'supervisor_id', 'id');
	}
																		}
