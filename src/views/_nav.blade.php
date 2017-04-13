<ul class="nav nav-tabs">
    @can('view_users')
        <li role="presentation"
            class="@if(\Route::currentRouteName() == 'RoleManager::home' OR \Route::currentRouteName() == 'RoleManager::viewUserRole') active @endif">
            <a href="{{route('RoleManager::home')}}">Role Manager Home</a>
        </li>
    @endcan
    @can('view_role')
        <li role="presentation" class="@if(starts_with(\Route::currentRouteName(), 'RoleManager::role')) active @endif">
            <a href="{{route('RoleManager::role.index')}}">Roles</a>
        </li>
    @endcan
    @can('view_permission')
        <li role="presentation"
            class="@if(starts_with(\Route::currentRouteName(), 'RoleManager::permission')) active @endif">
            <a href="{{route('RoleManager::permission.index')}}">Permissions</a>
        </li>
    @endcan
</ul>