<?php

namespace Vanguard\Repositories\Classroom;

use Vanguard\Classroom;

interface ClassroomRepository
{
    /**
     * Get all system roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'name', $key = 'id');

    public function getClassroomsByTeacherID($teacher);
    public function getClassroomsBySchoolID($school);
    public function getEmptyClassroomsBySchoolID($school);
    public function clearclassroom($classroom_id, $user_id);
    public function byID($classroom_id);

}
