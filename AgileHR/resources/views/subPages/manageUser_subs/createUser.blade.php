@extends("subPages.manageUsers")
@section("manageUserSubContent")

<div class="miniheader-subContents">
    <h3>Create new user</h3>
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

    <form method="post" action="AddNewUser" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @csrf
        <tr>
            <th>User's name</th>
            <th>username</th>
            <th>password</th>
            <th>e-mail</th>
            <th>Role</th>
            <th>Is Admin</th>            
        </tr>
        <tr> 
            <td><input type="text" name="Name" class="" required/></td>
            <td><input type="text" name="username" class="" required/></td>
            <td><input type="text" name="userPassword" class="" required/></td>
            <td><input type="text" name="userEmail" class="" required/></td>
            <td><select name="selectedRole">
                    @foreach($roles as $r)
                    <option value="{{$r['ID']}}">{{$r['RoleDescription']}}</option>
                    @endforeach
                </select>
            </td>
            <td><select name="isAdminSelection">
                    <option value="1">Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="add" class="" value="Add" /></td>
        </tr>
    </form>

@stop