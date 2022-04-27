@extends("subPages.manageSprints")
@section("manageSprintSubContent")
<div class="miniheader-subContents">
    <h3>Closed sprints</h3>
</div>

<div class="activitySite-subContents">
@if(!$sprints->isEmpty())
    <table class="formTable">
        <tr>
            <th>Sprint name</th>
            <th>Active</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        @foreach($sprints as $s)
        <tr>
            <td>{{$s['sprint_name']}}</td>
            <td>@if ($s['is_active'] === 1) Yes @else No @endif</td>            
            <td>{{$s['created_at']}}</td>
            <td>{{$s['updated_at']}}</td>
            <td>
                <a href={{"manageSprint_deleteSelectedSprint/".$s['ID']}}>Delete Sprint</a>                
            </td>       
        </tr>
        @endforeach
    </table>
@else 
    <div class="miniheader-subContents">
        <h5>No closed sprints available.</h5>
    </div>
@endif
</div>
@stop