@if(Session::has('message'))
    <div class="alert {{Session::has('message-status')? session('message-status'):'alert-success'}}">
        {{session('message')}}
    </div>
@endif