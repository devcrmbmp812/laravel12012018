<?php

namespace Vanguard\Repositories\Classroom;

use Vanguard\Classroom;
use Vanguard\Support\Authorization\CacheFlusherTrait;
use DB;

class EloquentClassroom implements ClassroomRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Classroom::all();
    }

    /**
     * {@inheritdoc}
     */
    public function lists($column = 'name', $key = 'id')
    {
        return Classroom::pluck($column, $key);
    }

    public function listall()
    {
        return Classroom::select(
          DB::raw("name"),'id')
                ->get();
    }

	//public function getClassroomsByTeacherID($teacher)
	public function getClassroomsByTeacherID($teacher)
	{
        //return Classroom::pluck('name', 'id')->where('user_id', '=', $teacher);
        //return Classroom::pluck('name', 'id');
		//return Classroom::where('user_id', $teacher)->pluck('name', 'id');
		return Classroom::select(
			DB::raw("name"),'id')
			->where('user_id', $teacher)
			->get();
	}

        public function getClassroomsBySchoolID($school)
        {
        //return Classroom::pluck('name', 'id')->where('user_id', '=', $teacher);
        //return Classroom::pluck('name', 'id');
                //return Classroom::where('user_id', $teacher)->pluck('name', 'id');
                return Classroom::select(
                        DB::raw("name"),'id')
                        ->where('school_id', $school)
                        ->get();
        }

        public function getEmptyClassroomsBySchoolID($school)
        {
        //return Classroom::pluck('name', 'id')->where('user_id', '=', $teacher);
        //return Classroom::pluck('name', 'id');
                        //->where('user_id', $school)
                //return Classroom::where('user_id', $teacher)->pluck('name', 'id');
                return Classroom::select(
                        DB::raw("name"),'id')
                        ->where([
				'user_id' => null,
				'school_id' => $school
			])
                        ->get();
        }

	public function clearclassroom($classroom_id, $user_id)
	{
		$updated = DB::table('classrooms')
				->where('id', $classroom_id)
				->update('user_id', $user_id);
	}
    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Classroom::where('name', $name)->first();
    }

    public function byID($classroom_id)
    {
        return Classroom::where('id', $classroom_id)->first();
    }

}
