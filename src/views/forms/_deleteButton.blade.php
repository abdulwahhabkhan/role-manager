<form action="{{$route or ''}}" class="{{'form-inline'}}" style="display: inline" method="post">
    {!! csrf_field() !!}
    <div class="btn-group pull-right" role="group" aria-label="...">
        {!! $otherElements or '' !!}
        {!! method_field('delete')!!}
        <button type="submit" onclick="return confirm('Do you really want to delete Item?')" class="btn btn-xs btn-danger">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
    </div>
</form>
