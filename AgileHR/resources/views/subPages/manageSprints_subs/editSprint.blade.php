@extends("subPages.manageSprints")
@section("manageSprintSubContent")

<div class="miniheader-subContents">
    <h3>Edit selected sprint</h3>
</div>
{{$data['ID']}}
<div class="activitySite-subContents">
    <table class="formTable">
    <form method="post" action=/{{"manageSprint_updateSelectedSprint/".$data['ID']}} enctype="multipart/form-data">
        @csrf
            <tr>
                <th>Sprint name</th>
                <th>Is Active</th>
                <th>Is Closed</th>
            </tr>
            <tr>
                <td><input type="text" name="sprintName" value="{{ $data->sprint_name }}" required/></td>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <td>
                    <select name="is_activedropdown">
                        @if ($data['is_active'] === 1)                        
                        <option value="1" selected="selected">Yes</option>
                        <option value="0">No</option>
                        @else
                        <option value="1">Yes</option>
                        <option value="0" selected="selected">No</option>
                        @endif                       
                    </select>
                </td>
                <td><select name="is_closeddropdown">
                        @if ($data['is_closed'] === 1)                        
                        <option value="1" selected="selected">Yes</option>
                        <option value="0">No</option>
                        @else
                        <option value="1">Yes</option>
                        <option value="0" selected="selected">No</option>
                        @endif     
                    </select>
                </td>                
            </tr>
            <tr><td colspan="3"><input type="submit" name="edit" value="Edit" /></td></tr>       
        </form>
    </table>
</div>

@stop