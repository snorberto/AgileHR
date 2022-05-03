@extends("subPages.managePosition")
@section("managePositionSubContent")

<div class="miniheader-subContents">
    <h3>All position statuses</h3>
</div>
@if(!$pos_status->isEmpty())
<div class="activitySite-subContents">
    <table class="formTable">
        <tr>
            <th>Position status</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        
        @foreach($pos_status as $p)
        <form method="post" action={{"/Edit_Selectedpos_status/".$p['ID']}} enctype="multipart/form-data">
            @csrf
            <tr>
                <td><input type="text" name = "edit_name_input" value="{{ $p['PositionStatus'] }}" required/></td>
                <td>{{$p['created_at']}}</td>
                <td>{{$p['updated_at']}}</td>
                <td>
                    @if($p['ID'] == 4 || $p['ID'] == 5)
                    @else
                    <a href={{"managePos_status_deleteSelectedStatus/".$p['ID']}}>Delete</a>
                    <br>
                    <input type="submit" name="edit" class="" value="Edit" />
                    @endif
                </td>       
            </tr>
        </form>
        @endforeach
        <tr>
            <form method="post" action="AddNewPos_status" enctype="multipart/form-data">
                @csrf        
                <td><input type="text" name = "add_name_input"  required/></td>
                <td><input type="submit" name="add" class="" value="Add" /></td>
            </form>
        </tr>
    </table>
</div>
@else
<div class="miniheader-subContents">
        <h5>No position statues available.</h5>
</div>
<table class="formTable">
    <tr>
        <th>Add new status</th>        
    </tr>
    <tr>
        <form method="post" action="AddNewPos_status" enctype="multipart/form-data">
            @csrf        
            <td><input type="text" name = "add_name_input"  required/></td>
            <td><input type="submit" name="add" class="" value="Add" /></td>
        </form>
    </tr>
</table>
@endif

@stop