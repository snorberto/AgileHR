@extends("mainSite.index")	 
@section("content")
<?php $viewName = 'ActiveSprint' ?>
<div class="header-subContents">
    <h1>Active Sprint board</h1>
</div>
 
@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif
<br>
@if($errors->any())
<div class="alert-danger">
    <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif

@if(!is_null($sprints))

    <div class="miniheader-subContents">
        <h3>{{$sprints->sprint_name}}</h3>
    </div>
    @if($positions->count() > 0)            
        <table class="formTable">
            <tr>
                <th>Title</th>
                <th>Current status</th>
                <th>Current assignee</th>
            </tr>
           
                @foreach($positions as $p)
                <tr>
                    <td><b><a href="{{ route('managePositions_SelectPosition', [$p['posID'], $viewName]) }}">{{$p->Title}}</a></b></td>
                    <td>{{$p->PositionStatus}}</td>
                    <td>@if(is_null($p->assignee_id)) - @else {{$p->username}} @endif </td>
                </tr>
                @endforeach

        </table>
    @else
        <div class="miniheader-subContents">
            <h5>No positions under active sprint available </h5>
        </div> 
    @endif

@else
<div class="miniheader-subContents">
    <h5>No active sprint available </h5>
</div>

@endif
@stop