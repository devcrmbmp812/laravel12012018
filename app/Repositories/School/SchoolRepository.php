<?php

namespace Vanguard\Repositories\School;

use Vanguard\School;

interface SchoolRepository
{
    /**
     * Get all system roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();
    public function byID($school_id);

    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'name', $key = 'id');

}
