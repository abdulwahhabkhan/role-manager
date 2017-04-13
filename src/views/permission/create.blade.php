@extends('RoleManager::main')

@section('roleManager-content')
    <h3>Create Permission  <a href="{{route('RoleManager::permission.index')}}" class="btn btn-sm btn-default  pull-right"> Back to permissions list</a></h3>
    <hr>
    <div class="row">
        <div class="col-md-10">
            @include('RoleManager::forms._wrapper', ['text' => 'Create Permission', 'route' => route('RoleManager::permission.store'), 'method'=> 'post', 'fields'=>'RoleManager::permission._fields'])
        </div>
    </div>
@endsection
