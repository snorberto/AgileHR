@extends("mainSite.index")	 
@section("content")

<div class="header-subContents">
    <h1>Manage users</h1>
</div>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif
<br>
<div class="navigation-subContents">
    <a href="/getAllUsers">Get all users</a>
    <a href="/createUser">Create new user</a>
    <a href="/searchUser">Search for user</a>
    <a href="/manageRoles">Manage Roles</a>
</div>

<div class="row">
    <div>    
        @yield("manageUserSubContent")
    </div>
</div>
@stop