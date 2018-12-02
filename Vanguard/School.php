<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{

	/**
	 * @var  string
	 */
	protected $table = 'schools';

	protected $casts = [
																																							'created_at' => 'datetime',
												'updated_at' => 'datetime',
											];
 
					public function user()
		{
			return $this->hasMany('Vanguard\User', 'id', 'school_id');
		}
																											}
