@extends("subPages.managePosition")
@section("managePositionSubContent")

<div class="miniheader-subContents">
    <h3>Search position</h3>
</div>

<table class="formTable">        

    <form method="post" action="StartSearchPosition" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @csrf
        <tr> 
            <td><input type="text" name="Searchbox_pos" class="" required placeholder="Search..."/></td>
            <td><input type="submit" name="searchpos_searchbtn" class="" value="Search" /></td>        
        </tr>
    </form>
</table>

@stop