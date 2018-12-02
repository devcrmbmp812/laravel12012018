@extends('layouts.app')

@section('page-title', trans('app.dashboard'))
@section('page-heading', trans('app.portal'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
	Access Files
    </li>
@stop

@section('content')

<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-primary flex-1">
                        <i class="fa fa-users fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Board Member Test</h2>
                        <div class="text-muted">Working</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@stop

@section('styles')
<style>
</style>
@stop

@section('scripts')
    <script>
        var users = {!! json_encode(array_values($usersPerMonth)) !!};
        var months = {!! json_encode(array_keys($usersPerMonth)) !!};
        var trans = {
            chartLabel: "{{ trans('app.registration_history')  }}",
            new: "{{ trans('app.new_sm') }}",
            user: "{{ trans('app.user_sm') }}",
            users: "{{ trans('app.users_sm') }}"
        };
    </script>
    {!! HTML::script('assets/js/chart.min.js') !!}
    {!! HTML::script('assets/js/as/dashboard-admin.js') !!}
@stop
