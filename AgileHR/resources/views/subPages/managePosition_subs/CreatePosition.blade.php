@extends("subPages.managePosition")
@section("managePositionSubContent")


<div class="miniheader-subContents">
    <h3>Create new position</h3>
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

    <form method="post" action="AddNewPosition" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="openerID" value="{{ Auth::user()->ID }}">
    @csrf
        <tr>
            <th>Position title</th>
            <th>Description</th>
            <th>Story points</th>     
        </tr>
        <tr> 
            <td><input type="text" name="pos_Title" class="" required/></td>
            <td><textarea rows=6 cols=60 name="pos_description" spellcheck="false" required></textarea></td>
            <td><input type="text" name="pos_storyPoints" class="" /></td>
        </tr>
        <tr>
            <td><input type="submit" name="add" class="" value="Add" /></td>
        </tr>
    </form>
</table>


@stop