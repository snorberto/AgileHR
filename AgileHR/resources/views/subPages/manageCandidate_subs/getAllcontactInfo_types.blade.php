@extends("subPages.manageCandidate")
@section("manageCandidateSubContent")

<div class="miniheader-subContents">
    <h3>All Contact information</h3>
</div>
@if(!$contact_type->isEmpty())
<div class="activitySite-subContents">
    <table class="formTable">
        <tr>
            <th>Contact Types</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        
        @foreach($contact_type as $c)
        <form method="post" action={{"/manage_editSelectedContactInfoType/".$c['ID']}} enctype="multipart/form-data">
            @csrf
            <tr>
                <td><input type="text" name = "edit_name_input" value="{{ $c['ContactType'] }}" required/></td>
                <td>{{$c['created_at']}}</td>
                <td>{{$c['updated_at']}}</td>
                <td>
                    <a href={{"manage_deleteSelectedContactInfoType/".$c['ID']}}>Delete</a>
                    <br>
                    <input type="submit" name="edit" class="" value="Edit" />
                </td>       
            </tr>
        </form>
        @endforeach
        <tr>
            <form method="post" action="AddNewContactInfo_type" enctype="multipart/form-data">
                @csrf        
                <td><input type="text" name = "add_name_input"  required/></td>
                <td><input type="submit" name="add" class="" value="Add" /></td>
            </form>
        </tr>
    </table>
</div>
@else
<div class="miniheader-subContents">
        <h5>No Contact information types available.</h5>
</div>
<table class="formTable">
    <tr>
        <th>Add new label</th>        
    </tr>
    <tr>
        <form method="post" action="AddNewContactInfo_type" enctype="multipart/form-data">
            @csrf        
            <td><input type="text" name = "add_name_input"  required/></td>
            <td><input type="submit" name="add" class="" value="Add" /></td>
        </form>
    </tr>
</table>
@endif
@stop