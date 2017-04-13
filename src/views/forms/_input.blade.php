<div class="form-group @if(!empty($errors->first($name))) has-error @endif">
    <label for="{{$name or 'name'}}" class="{{$label_class or 'col-md-6'}}">
        {{$label or ''}}
    </label>
    <div class="{{$div_class or 'col-md-6'}}">
        <input type="{{$type or 'text'}}" name="{{$name or 'name'}}" class="{{$class or 'form-control'}}" value="{{old(!empty($name)? $name : 'name', (!empty($model) and !empty($model->$name))?$model->{$name} : '')}}" placeholder="{{$placeholder or ''}}" {{$additional or ''}}>
        @if(!empty($errors->first($name)))  <span class="text-danger">{{$errors->first($name)}}</span> @endif

    </div>
</div>


