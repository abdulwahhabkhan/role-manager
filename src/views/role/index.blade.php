@extends('RoleManager::main')

@section('roleManager-content')
    <h3>Roles List <a class="btn btn-sm btn-success pull-right" href="{{route('RoleManager::role.create')}}">Add new
            Role</a></h3>
    <hr>
    @include('RoleManager::forms._search')

    <ul class="list-group">

        @forelse($roles as $role)
            <li class="list-group-item">
                {{$role->name}} :: {{$role->description}}
                @can('edit_role')
                    @include('RoleManager::forms._deleteButton', [
                        'route'=>route('RoleManager::role.destroy', $role->id),
                        'otherElements' =>'<a href="'.route('RoleManager::role.edit',$role->id).'" class="btn btn-xs  btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',
                        ])
                @endcan
            </li>
        @empty
            <li class="list-group-item">
                <div class="block">
                    There Are no Roles
                </div>
            </li>

        @endforelse
    </ul>

    @if(!empty(\Request::get('term')))
        {!! $roles->appends('term', \Request::get('term'))->links() !!}
    @else
        {!! $roles->links() !!}
    @endif
@endsection
