<?php

namespace Vanguard\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;


class Location extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = 'Vanguard\Location';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var  string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var  array
     */
    public static $search = [
        'name'
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
                                                                Text::make( 'Name',  'name')
->rules('required')
->sortable()
,
                                                                Text::make( 'Street Address',  'street_address')
->rules('required')
->sortable()
,
                                                                Text::make( 'City',  'city')
->rules('required')
->sortable()
,
                                                                Text::make( 'State',  'state')
->rules('required')
->hideFromIndex()
->sortable()
,
                                                                Number::make( 'Postal Code',  'postal_code')
->sortable()
,
                                                                                                                        Text::make( 'School Image',  'school_image')
->rules('required')
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
