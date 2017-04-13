@extends('RoleManager::main')

@section('roleManager-content')
    <h3>Update Permission <a href="{{route('RoleManager::permission.index')}}" class="btn btn-sm btn-default  pull-right"> Back to permissions list</a></h3>
    <hr>
    <div class="row">
        <div class="col-md-10">
            @include('RoleManager::forms._wrapper', ['text' => 'Update Permission', 'route' => route('RoleManager::permission.update', $permission->id), 'method'=> 'put', 'fields'=>'RoleManager::permission._fields', 'model'=>$permission])
        </div>
    </div>
@endsection