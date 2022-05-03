@extends("subPages.managePosition")
@section("managePositionSubContent")
<?php $viewName = 'getAllPos'; ?>
<div class="miniheader-subContents">
    <h3>All positions</h3>
</div>
<div class="activitySite-subContents">
@if(!$positions->isEmpty())
    <table class="formTable">
        <tr>
            <th>Position title</th>
            <th>Current position status</th>
            <th>Reporter</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        @foreach($positions as $p)
        <tr>
            <td><b><a href="{{ route('managePositions_SelectPosition', [$p['ID'], $viewName]) }}">{{$p['Title']}}</a></b></td>
            <td>{{$p['PositionStatus']}}</td>
            <td>{{$p['username']}}</td>
            <td>{{$p['created_at']}}</td>
            <td>{{$p['updated_at']}}</td>
            <td>
                <a href={{"managePositions_deleteSelectedPosition/".$p['ID']}}>Delete Position</a>
                <br>
                <a href="{{ route('managePositions_SelectPosition', [$p['ID'], $viewName]) }}">Edit Position</a> 
            </td>       
        </tr>
        @endforeach
    </table>
@else 
    <div class="miniheader-subContents">
        <h5>No positions available.</h5>
    </div>
@endif
</div>

@stop