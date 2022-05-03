@extends("subPages.manageCandidate")
@section("manageCandidateSubContent")

<div class="miniheader-subContents">
    <h3>All label types</h3>
</div>
@if(!$label_types->isEmpty())
<div class="activitySite-subContents">
    <table class="formTable">
        <tr>
            <th>Label value</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        
        @foreach($label_types as $l)
        <form method="post" action={{"/Edit_Selectedlabel_type/".$l['ID']}} enctype="multipart/form-data">
            @csrf
            <tr>
                <td><input type="text" name = "edit_name_input" value="{{ $l['Label_value'] }}" required/></td>
                <td>{{$l['created_at']}}</td>
                <td>{{$l['updated_at']}}</td>
                <td>
                    <a href={{"manageLabel_type_deleteSelectedLabel/".$l['ID']}}>Delete</a>
                    <br>
                    <input type="submit" name="edit" class="" value="Edit" />
                </td>       
            </tr>
        </form>
        @endforeach
        <tr>
            <form method="post" action="AddNewLabel_type" enctype="multipart/form-data">
                @csrf        
                <td><input type="text" name = "add_name_input"  required/></td>
                <td><input type="submit" name="add" class="" value="Add" /></td>
            </form>
        </tr>
    </table>
</div>
@else
<div class="miniheader-subContents">
        <h5>No labels available.</h5>
</div>
<table class="formTable">
    <tr>
        <th>Add new label</th>        
    </tr>
    <tr>
        <form method="post" action="AddNewLabel_type" enctype="multipart/form-data">
            @csrf        
            <td><input type="text" name = "add_name_input"  required/></td>
            <td><input type="submit" name="add" class="" value="Add" /></td>
        </form>
    </tr>
</table>
@endif
@stop