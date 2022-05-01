@extends("subPages.manageUsers")
@section("manageUserSubContent")

<div class="miniheader-subContents">
    <h3>Search users results</h3>
</div>
<div class="activitySite-subContents">
@if(!$users->isEmpty())
    <table class="formTable">
        <tr>
            <th>Name</th>
            <th>username</th>
            <th>e-mail</th>
            <th>Role</th>
            <th>Is Admin</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        @foreach($users as $u)
        <tr>
            <td>{{$u['Name']}}</td>
            <td>{{$u['username']}}</td>
            <td>{{$u['email']}}</td>
            <td>{{$u['RoleDescription']}}</td>
            <td>@if($u['isAdmin'] == 1) Yes @else No @endif</td>
            <td>@if(is_null($u['created_at'])) - @else {{$u['created_at']}} @endif</td>
            <td>@if(is_null($u['updated_at'])) - @else {{$u['updated_at']}} @endif</td>
            <td>
                @if(!$u['isAdmin']==1)
                <a href={{"manageUser_deleteSelectedUser/".$u['ID']}}>Delete User</a>
                <a href={{"manageUser_SelectUser/".$u['ID']}}>Edit User</a> 
                @endif
            </td>       
        </tr>
        @endforeach
    </table>
@else 
    <div class="miniheader-subContents">
        <h5>No users available. </h5>
    </div>
@endif
</div>
@stop