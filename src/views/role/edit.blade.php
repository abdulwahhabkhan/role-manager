@extends('RoleManager::main')

@section('roleManager-content')
    <h3>Update Role <a href="{{route('RoleManager::role.index')}}" class="btn btn-sm btn-default  pull-right"> Back to role list</a></h3>
    <hr>

    @include('RoleManager::forms._wrapper', ['text' => 'Update Role', 'route' => route('RoleManager::role.update', $role->id), 'method'=> 'put', 'fields'=>'RoleManager::role._fields', 'model'=>$role, 'valueList'=>$valueList])


@endsection