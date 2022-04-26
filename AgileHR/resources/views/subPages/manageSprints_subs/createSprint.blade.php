@extends("subPages.manageSprints")
@section("manageSprintSubContent")

<div class="miniheader-subContents">
    <h3>Create sprint</h3>
</div>

@if($errors->any())
<div class="alert-danger">
    <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif
<table class="formTable">        

    <form method="post" action="createNewSprint" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @csrf
        <tr>
            <th>Sprint name</th>
            <th>Set as active sprint</th>
        </tr>
        <tr> 
            <td><input type="text" name="sprintName" class="" required/></td>
            <td><select name="is_activedropdown">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="add" class="" value="Add" /></td>
        </tr>
    </form>
</table>



@stop