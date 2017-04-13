@extends('RoleManager::main')

@section('roleManager-content')
    <h3>
        Roles | {{$user->email}} - {{$user->name}}
        <a href="{{route('RoleManager::home')}}" class="btn btn-sm btn-default  pull-right"> Back to
            Users list
        </a>
    </h3>
    <hr>
    @include('RoleManager::forms._message')
    <form action="{{route('RoleManager::updateUserRole',$user->id)}}" method="post" class="form-horizontal">
        {!! csrf_field() !!}
        @forelse($roles as $role)
            <div class="form-group col-md-3">
                @include('RoleManager::forms._checkbox', ['name' => 'role['.$role->id.']', 'value'=>$role->id, 'text' =>$role->description, 'text_small'=>$role->name])
            </div>
        @empty
            There are no roles please at first <a href="{{route('RoleManager::role.create')}}">create it</a>.
        @endforelse
        @can('manage_user_roles')
            @if(count($roles)>0)
                <div class="clearfix"></div>
                @include('RoleManager::forms._button', ['text'=>'Update User Roles', 'div_class'=>'', 'class'=> 'btn btn-primary center-block'])
            @endif
        @endcan
    </form>
@endsection
