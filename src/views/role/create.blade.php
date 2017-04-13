@extends('RoleManager::main')

@section('roleManager-content')

    <h3>Create Role
        <a href="{{route('RoleManager::role.index')}}" class="btn btn-sm btn-default  pull-right"> Back to
            Role list
        </a>
    </h3>
    <hr>
    <div class="row">
        @include('RoleManager::forms._wrapper', ['text' => 'Create Role', 'route' => route('RoleManager::role.store'), 'method'=> 'post', 'fields'=>'RoleManager::role._fields'])
    </div>

@endsection