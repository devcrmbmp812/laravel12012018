<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{

	/**
	 * @var  string
	 */
	protected $table = 'classrooms';

	protected $casts = [
																																		'created_at' => 'datetime',
												'updated_at' => 'datetime',
						];
 
														public function user()
		{
			return $this->hasOne('Vanguard\User', 'user_id', 'id');
		}
							public function school()
		{
			return $this->hasOne('Vanguard\School', 'school_id', 'id');
		}
									}
