<?php

namespace Vanguard\Repositories\School;

use Vanguard\School;
use Vanguard\Support\Authorization\CacheFlusherTrait;
use DB;

class EloquentSchool implements SchoolRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return School::all();
    }

    /**
     * {@inheritdoc}
     */
    public function lists($column = 'name', $key = 'id')
    {
        return School::pluck($column, $key);
    }

    public function byID($school_id)
    {
        return School::where('id', $school_id)->first();
    }

    public function listall()
    {
        return School::select(
          DB::raw("name"),'id')
                ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return School::where('name', $name)->first();
    }

}
