@extends('layouts.app')

@section('page-title', trans('app.dashboard'))
@section('page-heading', trans('app.portal'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('app.dashboard')
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
                        <h2 class="text-right">{{ number_format($stats['total']) }}</h2>
                        <div class="text-muted">@lang('app.total_users')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-success flex-1">
                        <i class="fa fa-user fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['new']) }}</h2>
                        <div class="text-muted">@lang('app.new_users_this_month')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/user?search=&status=&role=3';" style="cursor: pointer;">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-danger flex-1">
                        <i class="fa fa-graduation-cap fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['teacher']) }}</h2>
                        <div class="text-muted">@lang('app.teachers')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/user?search=&status=&role=5';" style="cursor: pointer;">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-info flex-1">
                        <i class="fa fa-user-friends fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['parent']) }}</h2>
                        <div class="text-muted">@lang('app.parents')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('app.registration_history')</h5>
                <div class="pt-4 px-3">
                    <canvas id="myChart" height="365"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    @lang('app.latest_registrations')

                    @if (count($latestRegistrations))
                        <small class="float-right">
                            <a href="{{ route('user.list') }}">View All</a>
                        </small>
                    @endif
                </h5>

                @if (count($latestRegistrations))
                    <ul class="list-group list-group-flush">
                        @foreach ($latestRegistrations as $user)
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('user.show', $user->id) }}" class="d-flex text-dark no-decoration">
                                    <img class="rounded-circle" width="40" height="40" src="{{ $user->present()->avatar }}">
                                    <div class="ml-2" style="line-height: 1.2;">
                                        <span class="d-block p-0">{{ $user->present()->nameOrEmail }}</span>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">@lang('app.no_records_found')</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/user/create';" style="cursor: pointer;">
            <div class="card-body cardlink">
                <div class="row">
                    <div class="p-3 text-primary flex-1">
                        <i class="fa fa-user-plus fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Create</h2>
                        <div class="text-muted"><p class="text-right">New User</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/user';" style="cursor: pointer;">
            <div class="card-body cardlink">
                <div class="row">
                    <div class="p-3 text-primary flex-1">
                        <i class="fa fa-users fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">List</h2>
                        <div class="text-muted"><p class="text-right">All Users</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="col-xl-3 col-md-6">
      <div class="card widget" onclick="location.href='{{ route('user.adminlist') }}';" style="cursor: pointer;">
          <div class="card-body cardlink">
              <div class="row">
                  <div class="p-3 text-primary flex-1">
                      <i class="fa fa-user-shield fa-3x"></i>
                  </div>

                  <div class="pr-3">
                      <h2 class="text-right">Show</h2>
                      <div class="text-muted"><p class="text-right">Admin Users</p></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

<div class="col-xl-3 col-md-6">
      <div class="card widget" onclick="location.href='{{ route('user.boardmemberslist') }}';" style="cursor: pointer;">
          <div class="card-body cardlink">
              <div class="row">
                  <div class="p-3 text-primary flex-1">
                      <i class="fa fa-user-lock fa-3x"></i>
                  </div>

                  <div class="pr-3">
                      <h2 class="text-right">Show</h2>
                      <div class="text-muted"><p class="text-right">Board Members</p></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</div>
<div class="row">

<div class="col-xl-3 col-md-6">
      <div class="card widget" onclick="location.href='{{ route('user.employeelist') }}';" style="cursor: pointer;">
          <div class="card-body cardlink">
              <div class="row">
                  <div class="p-3 text-primary flex-1">
                      <i class="fa fa-user-clock fa-3x"></i>
                  </div>
    
                  <div class="pr-3">
                      <h2 class="text-right">Show</h2>
                      <div class="text-muted"><p class="text-right">Employees</p></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
<div class="col-xl-3 col-md-6">
      <div class="card widget" onclick="location.href='{{ route('user.fiscallist') }}';" style="cursor: pointer;">
          <div class="card-body cardlink">
              <div class="row">
                  <div class="p-3 text-primary flex-1">
                      <i class="fa fa-user-tag fa-3x"></i>
                  </div>

                  <div class="pr-3">
                      <h2 class="text-right">Show</h2>
                      <div class="text-muted"><p class="text-right">Fiscal Dept</p></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
<div class="col-xl-3 col-md-6">
      <div class="card widget" onclick="location.href='{{ route('user.teacherslist') }}';" style="cursor: pointer;">
          <div class="card-body cardlink">
              <div class="row">
                  <div class="p-3 text-primary flex-1">
                      <i class="fa fa-user-graduate fa-3x"></i>
                  </div>

                  <div class="pr-3">
                      <h2 class="text-right">Show</h2>
                      <div class="text-muted"><p class="text-right">Teachers</p></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
<div class="col-xl-3 col-md-6">
      <div class="card widget" onclick="location.href='{{ route('user.parentlist') }}';" style="cursor: pointer;">
          <div class="card-body cardlink">
              <div class="row">
                  <div class="p-3 text-primary flex-1">
                      <i class="fa fa-user-friends fa-3x"></i>
                  </div>

                  <div class="pr-3">
                      <h2 class="text-right">Show</h2>
                      <div class="text-muted"><p class="text-right">Parents</p></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</div>

<div class="row">
<div class="col-xl-3 col-md-6">
        <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/role';" style="cursor: pointer;">
            <div class="card-body cardlink">
                <div class="row">
                    <div class="p-3 text-primary flex-1">
                        <i class="fa fa-user-cog fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Manage</h2>
                        <div class="text-muted"><p class="text-right">User Roles</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/permission';" style="cursor: pointer;">
            <div class="card-body cardlink">
                <div class="row">
                    <div class="p-3 text-primary flex-1">
                        <i class="fa fa-sliders-h fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Manage</h2>
                        <div class="text-muted"><p class="text-right">Permissions</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="col-xl-3 col-md-6">
    <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/activity';" style="cursor: pointer;">
        <div class="card-body cardlink">
            <div class="row">
                <div class="p-3 text-primary flex-1">
                    <i class="fa fa-file-alt fa-3x"></i>
                </div>

                <div class="pr-3">
                    <h2 class="text-right">View</h2>
                    <div class="text-muted"><p class="text-right">User Activity</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card widget" onclick="location.href='http://dashboard.cabc-bchs.org/nova';" style="cursor: pointer;">
        <div class="card-body cardlink">
            <div class="row">
                <div class="p-3 text-primary flex-1">
                    <i class="fa fa-database fa-3x"></i>
                </div>

                <div class="pr-3">
                    <h2 class="text-right">Manage</h2>
                    <div class="text-muted"><p class="text-right">System Database</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- end class row -->

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
