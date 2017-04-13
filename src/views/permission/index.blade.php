@extends('RoleManager::main')

@section('roleManager-content')
    <h3>Permissions List <a class="btn btn-sm btn-success pull-right"
                            href="{{route('RoleManager::permission.create')}}">Add new Permission</a></h3>
    <hr>
    @include('RoleManager::forms._search')
    @include('RoleManager::forms._message')
    <ul class="list-group">

        @forelse($permissions as $permission)
            <li class="list-group-item">
                {{$permission->name}} :: {{$permission->description}}
                @can('edit_permission')
                    @include('RoleManager::forms._deleteButton', [
                    'route'=>route('RoleManager::permission.destroy', $permission->id),
                    'otherElements' =>'<a href="'.route('RoleManager::permission.edit',$permission->id).'" class="btn btn-xs  btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',
                    ])
                @endcan
            </li>
        @empty
            <li class="list-group-item">
                <div class="block">
                    There Are no Permissions
                </div>
            </li>

        @endforelse
    </ul>
    @if(!empty(\Request::get('term')))
        {!! $permissions->appends('term', \Request::get('term'))->links() !!}
    @else
        {!! $permissions->links() !!}
    @endif
@endsection
