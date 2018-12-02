<?php

namespace Vanguard\Repositories\Position;

use Vanguard\Position;

interface PositionRepository
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
    public function lists($column = 'position_title', $key = 'id');
    public function byID($position_id);

}
