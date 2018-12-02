<?php

namespace Vanguard\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Vanguard\Repositories\School\EloquentSchool',
            'Vanguard\Repositories\School\SchoolRepository',
            'Vanguard\Repositories\Classroom\EloquentClassroom',
            'Vanguard\Repositories\Classroom\ClassroomRepository',
	    'Vanguard\Repositories\Position\EloquentPosition',
	    'Vanguard\Repositories\Position\PositionRepository',
	    'Vanguard\Repositories\Parent\ParentRepository',
	    'Vanguard\Repositories\Parent\EloquentParent');
    }
}
