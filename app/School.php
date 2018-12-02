<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
	protected $table = 'locations';    //

    protected $fillable = ['name', 'city', 'school_image'];

    public function users()
    {
        return $this->hasMany(User::class, 'school_id');
    }
    public function user()
    {
        return $this->hasMany(User::class, 'school_id');
    }
    public function classroom()
    {
	return $this->hasMany(Classroom::class, 'school_id');
    }

}
