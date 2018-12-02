@extends('layouts.app')

@section('page-title', trans('app.add_user'))
@section('page-heading', trans('app.create_new_user'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('user.list') }}">@lang('app.users')</a>
    </li>
    <li class="breadcrumb-item active">
        @lang('app.create')
    </li>
@stop

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'user.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('app.user_details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        A general user profile information.
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.details', ['edit' => false, 'profile' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="school_card" style="display: none;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
			School Information
                    </h5>
                    <p class="text-muted font-weight-light">
                        Assign users (teachers & parents) to schools & classrooms.
                    </p>
                </div>
                <div class="col-md-9">
	<div class="form-group">
    <label>Assigned Location</label>
        <select name="school_id" id="school_id" class="form-control input-sm">
            <option value="">None Assigned</option>
            @foreach($schools as $school)
            <option value="{{ $school->id }}">{{ $school->name}}</option>
            @endforeach
           </select>
	</div>

                    <div id="parent_card" style="display: none;">
                    @include('user.partials.parents', ['edit' => false, 'profile' => false])
                    </div>
                    <div id="teacher_card" style="display: none;">
                    @include('user.partials.teachers', ['edit' => false, 'profile' => false])
                    </div>

<div class="form-group">
    <label>Assigned Class
        <select id="classroom_id" class="form-control input-sm" name="classroom_id">
            <option value="">...</option>
       </select>
    </label>
</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('app.login_details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        Details used for authenticating with the application.
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.auth', ['edit' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('app.create_user')
            </button>
        </div>
    </div>
{!! Form::close() !!}

<br>
@stop

@section('scripts')
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! HTML::script('assets/js/selectlogic.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\CreateUserRequest', '#user-form') !!}
@stop
