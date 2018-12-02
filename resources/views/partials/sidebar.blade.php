<nav class="col-md-2 sidebar">
    <div class="user-box text-center pt-5 pb-3">
        <div class="user-img">
            <img src="{{ auth()->user()->present()->avatar }}"
                 width="90"
                 height="90"
                 alt="user-img"
                 class="rounded-circle img-thumbnail img-responsive">
        </div>
        <h5 class="my-3">
            <a href="{{ route('profile') }}">{{ auth()->user()->present()->nameOrEmail }}</a>
	    @if(auth()->user()->role_id == "1")
	    <br /><div style="color: white; font-size: 11px; margin-top: 0px;">Admin</div>
	    @elseif(auth()->user()->role_id == "3") 
	    <br /><div style="color: white; font-size: 11px; margin-top: 0px;">Teacher</div>
	    @elseif(auth()->user()->role_id == "5")
	    <br /><div style="color: white; font-size: 11px; margin-top: 0px;">Parent</div>
	    @endif
        </h5>

        <ul class="list-inline mb-2">
            <li class="list-inline-item">
                <a href="{{ route('profile') }}" title="@lang('app.my_profile')">
                    <i class="fas fa-cog"></i>
                </a>
            </li>

            <li class="list-inline-item">
                <a href="{{ route('auth.logout') }}" class="text-custom" title="@lang('app.logout')">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : ''  }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>@lang('app.dashboard')</span>
                </a>
            </li>

@permission('resources.manage')
    <li class="nav-item">
        <a href="{{ Nova::path() }}" class="nav-link {{ Request::is('nova') ? 'active' : ''  }}">
            <i class="fas fa-database"></i>
                Resources       
        </a>
    </li>

@endpermission

@permission('view.filesystem')
    <li class="nav-item">
        <a href="/media" class="nav-link {{ Request::is('media') ? 'active' : ''  }}">
            <i class="fas fa-copy"></i>
                File Manager       
        </a>
    </li>
@endpermission
            @permission('users.manage')
            <li class="nav-item">
                <a href="#users-dropdown"
                   class="nav-link"
                   data-toggle="collapse"
                   aria-expanded="{{ Request::is('teachers') || Request::is('employees') || Request::is('fiscal') || Request::is('user*') || Request::is('activity*') || Request::is('admins') || Request::is('boardmembers') || Request::is('active-users') ? 'true' : 'false' }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>User Management</span>
                </a>
                <ul class="{{ Request::is('teachers') || Request::is('employees') || Request::is('fiscal') || Request::is('user*') || Request::is('activity*') || Request::is('admins') || Request::is('boardmembers') || Request::is('active-users') ? '' : 'collapse' }} list-unstyled sub-menu" id="users-dropdown">
            	    <li class="nav-item">
                	<a class="nav-link {{ Request::is('user*') ? 'active' : ''  }}" href="{{ route('user.list') }}">
                    	<span>All @lang('app.users')</span>
                	</a>
            	    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admins') ? 'active' : ''  }}" href="{{ route('user.adminlist') }}">
                        <span>Admin @lang('app.users')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('boardmembers') ? 'active' : ''  }}" href="{{ route('user.boardmemberslist') }}">
                        <span>Board Members</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('employees') ? 'active' : ''  }}" href="{{ route('user.employeelist') }}">
                        <span>Employees</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('fiscal') ? 'active' : ''  }}" href="{{ route('user.fiscallist') }}">
                        <span>Fiscal Dept</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('teachers') ? 'active' : ''  }}" href="{{ route('user.teacherslist') }}">
                        <span>Teachers</span>
                        </a>
                    </li>
            	    @permission('users.activity')
                    <li class="nav-item">
                	<a class="nav-link {{ Request::is('activity*') ? 'active' : ''  }}" href="{{ route('activity.index') }}">
                    	<span>@lang('app.activity_log')</span>
                	</a>
            	    </li>
            	    @endpermission
    		   <li class="nav-item">
        		<a href="{{ route('active-users') }}" class="nav-link {{ Request::is('active-users') ? 'active' : ''  }}">
            		<span>Active Users</span>
        		</a>
    		    </li>
                </ul>
            </li>
            @endpermission

            @permission('parents.manage')
            <li class="nav-item">
                <a href="#parents-dropdown"
                   class="nav-link"
                   data-toggle="collapse"
                   aria-expanded="{{ Request::is('parent*') ? 'true' : 'false' }}">
                    <i class="fas fa-user-friends"></i>
                    <span>Parent Management</span>
                </a>
                <ul class="{{ Request::is('parent*') || Request::is('parent/*/*') ? '' : 'collapse' }} list-unstyled sub-menu" id="parents-dropdown">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('parents') || Request::is('parent/*/*') ? 'active' : ''  }}" href="{{ route('user.parentlist') }}">
                        <span>All @lang('app.parents')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('parent/create') ? 'active' : ''  }}" href="{{ route('user.createparent') }}">
                        <span>Create Parent</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endpermission
            
            @permission(['roles.manage', 'permissions.manage'])
            <li class="nav-item">
                <a href="#roles-dropdown"
                   class="nav-link"
                   data-toggle="collapse"
                   aria-expanded="{{ Request::is('role*') || Request::is('permission*') ? 'true' : 'false' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>@lang('app.roles_and_permissions')</span>
                </a>
                <ul class="{{ Request::is('role*') || Request::is('permission*') ? '' : 'collapse' }} list-unstyled sub-menu" id="roles-dropdown">
                    @permission('roles.manage')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('role*') ? 'active' : '' }}"
                           href="{{ route('role.index') }}">@lang('app.roles')</a>
                    </li>
                    @endpermission
                    @permission('permissions.manage')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('permission*') ? 'active' : '' }}"
                           href="{{ route('permission.index') }}">@lang('app.permissions')</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission



            @permission(['settings.general', 'settings.auth', 'settings.notifications'], false)
            <li class="nav-item">
                <a href="#settings-dropdown"
                   class="nav-link"
                   data-toggle="collapse"
                   aria-expanded="{{ Request::is('settings*') ? 'true' : 'false' }}">
                    <i class="fas fa-cogs"></i>
                    <span>@lang('app.settings')</span>
                </a>
                <ul class="{{ Request::is('settings*') ? '' : 'collapse' }} list-unstyled sub-menu"
                    id="settings-dropdown">

                    @permission('settings.general')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings') ? 'active' : ''  }}"
                           href="{{ route('settings.general') }}">
                            @lang('app.general')
                        </a>
                    </li>
                    @endpermission

                    @permission('settings.auth')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/auth*') ? 'active' : ''  }}"
                           href="{{ route('settings.auth') }}">@lang('app.auth_and_registration')</a>
                    </li>
                    @endpermission

                    @permission('settings.notifications')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/notifications*') ? 'active' : ''  }}"
                           href="{{ route('settings.notifications') }}">@lang('app.notifications')</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
        </ul>
    </div>
</nav>


