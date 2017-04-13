<div class="col-md-10">
    @include("RoleManager::forms._input", ['label'=> "Role Name", 'name'=>'name', 'placeholder'=>'Fill Role Name'])
    @include("RoleManager::forms._input", ['label'=> "Role Description", 'name'=>'description', 'placeholder'=>'Fill Role Short Description'])
</div>
<div class="clearfix"></div>
<div class="col-md-12">
    <h4>Permissions</h4>
    <hr>
    @if(!empty($errors->get('permission.*')))
        <div class="alert alert-danger">
            Selected Permission Does Not exist
        </div>
    @endif
    <div class="form-group">
        <div class="col-md-12 checkbox">
            <label>
                <input type="checkbox"  onclick="toggle(this, 'permission')">Check All

            </label>
        </div>
    </div>
    @forelse($permissions as $permission)
        <div class="form-group col-md-3">
            @include('RoleManager::forms._checkbox', ['name' => 'permission['.$permission->id.']', 'value'=>$permission->id, 'text' =>$permission->description, 'text_small'=> $permission->name, 'class' =>'permission'])
        </div>
    @empty

        There are no Permissions, you can  <a href="{{route('RoleManager::permission.create')}}">create it</a>
    @endforelse
</div>
@include('RoleManager::forms._button', ['text'=>$text, 'class'=>'btn btn-primary center-block', 'div_class'=> ''])
<script>
    function toggle(ele, name) {
        var checkboxes = document.getElementsByClassName(name);
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
</script>