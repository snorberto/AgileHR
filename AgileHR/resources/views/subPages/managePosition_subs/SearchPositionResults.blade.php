@extends("subPages.managePosition")
@section("managePositionSubContent")

<div class="miniheader-subContents">
    <h3>Search position results</h3>
</div>
<div class="activitySite-subContents">
@if(!$positions->isEmpty())
    <table class="formTable">
        <tr>
            <th>Position title</th>
            <th>Reporter</th>
            <th>Current Assignee</th>
            <th>Current position status</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        @foreach($positions as $p)
        <tr>
            <td><a href=#>{{$p['Title']}}</a></td>
            <td>{{$p['username']}}</td>
            <td>@if(!is_null($p['assignee_username'])) {{$p['assignee_username']}} @else - @endif</td>
            <td>{{$p['PositionStatus']}}
            <td>@if(is_null($p['created_at'])) - @else {{$p['created_at']}} @endif</td>
            <td>@if(is_null($p['updated_at'])) - @else {{$p['updated_at']}} @endif</td>
            <td>
                <a href={{"managePositions_deleteSelectedPosition/".$p['ID']}}>Delete Position</a>
                <br>
                <a href=#>Edit Position</a> 
            </td>       
        </tr>
        @endforeach
    </table>
@else 
    <div class="miniheader-subContents">
        <h5>No positions available. </h5>
    </div>
@endif
</div>

@stop