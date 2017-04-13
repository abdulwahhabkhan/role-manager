@include('RoleManager::forms._message')
<form action="{{$route or ''}}" class="form-horizontal" @if(isset($method) and strtolower($method) != 'get') method="post" @else method="get" @endif>
    {!! csrf_field() !!}
    @if(isset($method) and strtolower($method) != 'get' and strtolower($method)!='post')
        {!! method_field($method) !!}
        @endif
    @include($fields)
</form>