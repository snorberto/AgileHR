@extends("subPages.manageCandidate")
@section("manageCandidateSubContent")


<div class="miniheader-subContents">
    <h3>Add new candidate profile</h3>
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

    <form method="post" action="AddNewCandidate" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @csrf
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Link to LinkedIn profile</th>     
        </tr>
        <tr> 
            <td><input type="text" name="can_Name" class="" required/></td>
            <td><textarea rows=6 cols=60 name="can_description" spellcheck="false"></textarea></td>
            <td><input type="text" name="can_Link" class=""/></td>

        </tr>
        <tr>
            <td colspan=4><input type="submit" name="add" class="" value="Add" /></td>
        </tr>
    </form>
</table>


@stop