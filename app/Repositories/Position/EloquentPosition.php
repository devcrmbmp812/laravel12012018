<?php

namespace Vanguard\Repositories\Position;

use Vanguard\Position;
use Vanguard\Support\Authorization\CacheFlusherTrait;
use DB;

class EloquentPosition implements PositionRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Position::all();
    }

    /**
     * {@inheritdoc}
     */
    public function lists($column = 'position_title', $key = 'id')
    {
        return Position::pluck($column, $key);
    }

    public function listall()
    {
        return Position::select(
          DB::raw("position_title"),'id')
                ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Position::where('position_title', $name)->first();
    }
    public function byID($position_id)
    {
        return Position::where('id', $position_id)->first();
    }
}
