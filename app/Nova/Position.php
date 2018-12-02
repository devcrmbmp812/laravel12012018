<?php

namespace Vanguard\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;


class Position extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = 'Vanguard\Position';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var  string
     */
    public static $title = 'position_title';

    /**
     * The columns that should be searched.
     *
     * @var  array
     */
    public static $search = [
        'id', 'position_title'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function fields(Request $request)
    {
        return [
                                                ID::make( 'Id',  'id')
->rules('required')
->sortable()
,
                                                                HasMany::make('User')
->rules('required')
->sortable()
,
                                                                Text::make( 'Position Title',  'position_title')
->rules('required')
->sortable()
,
                                                                Text::make( 'Position Status',  'position_status')
->rules('required')
->hideFromIndex()
->sortable()
,
                                                                Text::make( 'Program Id',  'program_id')
->rules('required')
->hideFromIndex()
->sortable()
,
                                                                Text::make( 'Earnings Code',  'earnings_code')
->rules('required')
->hideFromIndex()
->sortable()
,
                                                                Text::make( 'District Code Id',  'district_code_id')
->rules('required')
->hideFromIndex()
->sortable()
,
                                                                HasMany::make('User')
->hideFromIndex()
->sortable()
,
                                                                Text::make( 'Wage Grade',  'wage_grade')
->rules('required')
->hideFromIndex()
->sortable()
,
                                                                Text::make( 'Bc1',  'bc1')
->hideFromIndex()
->sortable()
,
                                                                Text::make( 'Bc2',  'bc2')
->hideFromIndex()
->sortable()
,
                                                                                            ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
