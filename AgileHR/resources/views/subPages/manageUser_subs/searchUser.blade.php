@extends("subPages.manageUsers")
@section("manageUserSubContent")

<div class="miniheader-subContents">
    <h3>Search user</h3>
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

    <form method="post" action="StartSearchUser" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @csrf
        <tr> 
            <td><input type="text" name="Searchbox_user" class="" required placeholder="Search..."/></td>
            <td><input type="submit" name="searchuser_searchbtn" class="" value="Search" /></td>        
        </tr>
    </form>
</table>

@stop