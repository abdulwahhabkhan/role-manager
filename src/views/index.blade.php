@extends('RoleManager::main')

@section('roleManager-content')
    <h3>Users List</h3>
    <hr>
    @include('RoleManager::forms._search')
    <ul class="list-group">

        @forelse($users as $user)
            <li class="list-group-item">{{$user->email}}
                @can('manage_user_roles')
                    <a href="{{route('RoleManager::viewUserRole', $user->id)}}"
                       class="btn btn-xs btn-primary pull-right">Manage</a>
                @endcan

            </li>
        @empty
            <li class="list-group-item">
                <div class="block">
                    There Are no user
                </div>
            </li>

        @endforelse
    </ul>

    @if(!empty(\Request::get('term')))
        {!! $users->appends('term', \Request::get('term'))->links() !!}
    @else
        {!! $users->links() !!}
    @endif
@endsection
