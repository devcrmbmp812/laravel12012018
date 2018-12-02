<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
	protected $table = 'classrooms';    //

    protected $fillable = ['name', 'city', 'school_image'];

    public function user()
    {
	//return $flights;
        //return $this->HasOne(User::class, 'id')->where('first', '=', '3');
	$flights = $this->BelongsTo(User::class, 'id')->where('role_id', '=', '3')->get();
	info('testhere');
	info($flights);
        return $this->BelongsTo(User::class, 'user_id');
    }
    public function location()
    {
        return $this->BelongsTo(Location::class, 'school_id');
    }

}
