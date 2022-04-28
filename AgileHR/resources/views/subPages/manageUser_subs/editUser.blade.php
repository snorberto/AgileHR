@extends("subPages.manageUsers")
@section("manageUserSubContent")

<div class="miniheader-subContents">
    <h3>Edit selected User</h3>
</div>

<div class="activitySite-subContents">
    <table class="formTable">
    <form method="post" action=/{{"manageUser_updateSelectedUser/".$data['ID']}} enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf
            <tr>
                <th>Name</th>
                <th>username</th>
                <th>e-mail</th>
                <th>Role</th>
                <th>Is Admin</th>
            </tr>
            <tr>
                <td><input type="text" name="User_name_edit" value="{{ $data->Name }}" required/></td>
                <td><input type="text" name="User_username_edit" value="{{ $data->username }}" required/></td>
                <td><input type="text" name="User_email_edit" value="{{ $data->email }}" required/></td>
                <td>
                    <select name="selectedRole">
                        @foreach($roles as $r)
                        <option value="{{$r['ID']}}" @if($r['RoleDescription'] == $data['RoleDescription']) selected @endif >{{$r['RoleDescription']}} </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="isAdminSelection">
                        <option value="1" @if($data['isAdmin']==1) selected @endif>Yes</option>
                        <option value="0" @if($data['isAdmin']==0) selected @endif>No</option>
                    </select>
                </td>                               
            </tr>
            <tr>
                <td colspan="5"><input type="submit" name="edit" value="Edit" /></td>
            </tr>
        </form>
    </table>
</div>

@stop