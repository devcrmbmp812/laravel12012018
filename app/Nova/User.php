<?php

namespace Vanguard\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Vanguard\\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
public function title()
{
        $return_name = $this->first_name." ".$this->last_name;
    return $return_name;
}

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name', 'last_name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),


            Gravatar::make(),

	    Text::make('First Name','first_name')
		->sortable()
		->onlyOnForms()
		->rules('required','max:255'),

	    Text::make('Last Name','last_name')
		->sortable()
		->onlyOnForms()
		->rules('required','max:255'),

	    Text::make('Name', function () {
    return $this->first_name.' '.$this->last_name;
}),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

	    Text::make('Phone')
		->onlyOnForms(),

	    Text::make('Address')
		->onlyOnForms(),

	    new Panel('Account Type', $this->accountFields()),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),


        ];
    }

protected function accountFields()
{
    return [
	    BelongsTo::make('Role'),

            BelongsTo::make('Position')
		->hideFromIndex(),

	    BelongsTo::make('Locations')
		->hideFromIndex(),

            BelongsTo::make('Classrooms')
		->hideFromIndex(),

            Select::make('Status')->options([
                    'Active' => 'Active',
                    'Banned' => 'Banned',
                    'Unconfirmed' => 'Unconfirmed',
                    'Archived' => 'Archived',
            ]),
    ];
}

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
