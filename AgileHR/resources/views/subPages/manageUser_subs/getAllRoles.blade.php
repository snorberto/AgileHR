@extends("subPages.manageUsers")
@section("manageUserSubContent")

<div class="miniheader-subContents">
    <h3>All Roles</h3>
</div>
<div class="activitySite-subContents">
@if(!$roles->isEmpty())
    <table class="formTable">
        <tr>
            <th>ID</th>
            <th>Role Description</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        @foreach($roles as $r)
        <tr>
            <td>{{$r['ID']}}</td>
            <td>{{$r['RoleDescription']}}</td>
            <td>@if(is_null($r['created_at'])) - @else {{$r['created_at']}} @endif</td>
            <td>@if(is_null($r['updated_at'])) - @else {{$r['updated_at']}} @endif</td>
            <td>
                @if($r['RoleDescription'] != "Admin")
                <a href={{"manageRole_deleteSelectedRole/".$r['ID']}}>Delete Role</a>
                <a href={{"manageRole_SelectRole/".$r['ID']}}>Edit Role</a> 
                @endif
            </td>       
        </tr>
        @endforeach
       
        <tr>
            <form method="post" action="AddNewRole" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @csrf
                <td><input type="text" name="RoleDesc_new" class="" required/></td>
                <td><input type="submit" name="add" class="" value="Add" /></td>
            </form>
        </tr>        
    </table>
@else 
    <div class="miniheader-subContents">
        <h5>No roles available </h5>
    </div>
@endif
</div>
@stop