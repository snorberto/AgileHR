@extends("subPages.manageUsers")
@section("manageUserSubContent")

<div class="miniheader-subContents">
    <h3>Edit selected role</h3>
</div>

<div class="activitySite-subContents">
    <table class="formTable">
    <form method="post" action=/{{"manageRole_updateSelectedRole/".$data['ID']}} enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf
            <tr>
                <th>Role Description</th>
            </tr>
            <tr>
                <td><input type="text" name="RoleDesc_editRole" value="{{ $data->RoleDescription }}" required/></td>
                <td><input type="submit" name="edit" value="Edit" /></td>               
            </tr>
        </form>
    </table>
</div>

@stop