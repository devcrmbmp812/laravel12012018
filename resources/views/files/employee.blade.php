@extends('layouts.app')

@section('page-title', 'Employee File Access')
@section('page-heading', 'Employee File Access')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
	Home
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
                        <h2 class="text-right">Employee Test</h2>
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
    {!! HTML::script('assets/js/chart.min.js') !!}
    {!! HTML::script('assets/js/as/dashboard-admin.js') !!}
@stop
