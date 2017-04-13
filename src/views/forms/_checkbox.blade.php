<div class="{{$div_class or 'checkbox'}}">
    <label>
        <input type="checkbox"
               @if(!empty(old(str_replace('[', '.', str_replace(']','',!empty($name)? $name : 'name')))) or (isset($valueList) and in_array($value, $valueList)))
               checked="checked"
               @endif
                       class="{{$class or ''}}"
               name="{{$name or ''}}" value="{{$value or ''}}"> {{$text}} <span class="text-muted"
                                                                                style="display: block; font-size: 0.8em;">{{$text_small or ''}}</span>
    </label>
</div>