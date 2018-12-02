<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	/**
	 * @var  string
	 */
	protected $table = 'roles';

	protected $casts = [
																																		'created_at' => 'datetime',
												'updated_at' => 'datetime',
						];
 
					public function user()
		{
			return $this->hasMany('Vanguard\User', 'id', 'role_id');
		}
																					}
