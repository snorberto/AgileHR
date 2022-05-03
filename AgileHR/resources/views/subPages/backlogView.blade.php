@extends("mainSite.index")	 
@section("content")
<?php $viewName = 'backlogView'; ?>
<div class="header-subContents">
    <h1>Backlog view</h1>
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



<!-- Active sprint -->
@if(!is_null($sprints_active))
    <div class="miniheader-subContents">
        <h3>Active sprint: {{$sprints_active->sprint_name}}</h3>
    </div>
    <!--check if there are positions assigned to active sprint -->
    @if($positions_assigned->count() > 0)
        <?php $counter_active = 0; ?>
        @foreach($positions_assigned as $pa)
            <?php                
                if($pa->sprintID == $sprints_active->ID){
                    $counter_active = $counter_active  + 1;
                }
            ?>
        @endforeach
        
        <!-- if there's position assigned:-->
        @if($counter_active > 0)
                <table class="formTable">
                    <tr>
                        <th>Position title</th>
                        <th>Position status</th>
                        <th>Assign to sprint</th>
                    </tr>                    
                    @foreach($positions_assigned as $pa)
                        @if($pa->sprintID == $sprints_active->ID)
                            <tr>
                                <td><b><a href="{{ route('managePositions_SelectPosition', [$pa['ID'], $viewName]) }}">{{$pa->Title}}</a></b></td>
                                <td>{{$pa->PositionStatus}}</td>
                                <form method="post" action={{"/backlog_assignToSprint/".$pa['ID']}} enctype="multipart/form-data">
                                    @csrf
                                    <td><select name="backlog_selectedSprint">
                                            <option value="">-</option>
                                            @foreach($all_open_sprints as $aos)
                                            <option value="{{$aos['ID']}}" @if($aos['ID'] == $pa['sprintID']) selected @endif >{{$aos['sprint_name']}} </option>
                                            @endforeach
                                        </select>                            
                                    </td>
                                    <td><input type="submit" name="edit" value="Assign to sprint" /></td>
                                </form>
                            </tr>
                        @endif
                    @endforeach
                </table>
        @else
            <div class="miniheader-subContents">
                <h5>No positions available</h5>
            </div>     
        @endif
    @else
        <div class="miniheader-subContents">
            <h5>No positions available</h5>
        </div>
    @endif
@else
    <div class="miniheader-subContents">
            <h5>No active sprint available</h5>
    </div>
@endif

@if($sprints_other->count() > 0)
    @foreach($sprints_other as $so)
        <div class="miniheader-subContents">
            <h3>{{$so->sprint_name}}</h3>
        </div>
        <?php $counter = 0; ?>
        @foreach($positions_assigned as $pa)
            <?php                
                if($pa->sprintID == $so->ID){
                    $counter +=1;
                }
            ?>
        @endforeach
        @if($counter > 0)
            <table class="formTable">
                <tr>
                    <th>Position title</th>
                    <th>Position status</th>
                    <th>Assign to sprint</th>
                </tr>
                @foreach($positions_assigned as $pa)
                    @if($pa->sprintID == $so->ID)
                    <tr>
                        <td><b><a href="{{ route('managePositions_SelectPosition', [$pa['ID'], $viewName]) }}">{{$pa->Title}}</a></b></td>
                        <td>{{$pa->PositionStatus}}</td>
                        <form method="post" action={{"/backlog_assignToSprint/".$pa['ID']}} enctype="multipart/form-data">
                        @csrf
                        <td><select name="backlog_selectedSprint">
                                <option value="">-</option>
                                @foreach($all_open_sprints as $aos)
                                    <option value="{{$aos['ID']}}" @if($aos['ID'] == $pa['sprintID']) selected @endif >{{$aos['sprint_name']}} </option>
                                @endforeach
                            </select>                            
                        </td>
                        <td><input type="submit" name="edit" value="Assign to sprint" /></td>
                    </form>
                    </tr>
                    @endif
                @endforeach 
            </table>       
        @else
            <div class="miniheader-subContents">
                <h5>No positions available</h5>
            </div>                
        @endif
    @endforeach

@else
    <div class="miniheader-subContents">
            <h5>No other sprints available</h5>
    </div>
@endif
<div class="miniheader-subContents">
        <h3>Backlog</h3>
</div>
@if($positions_backlog->count() > 0)
    <table class="formTable">
        
        <tr>
            <th>Position title</th>
            <th>Position status</th>
            <th>Assign to sprint</th>
        </tr>
    @foreach($positions_backlog as $pb)
                
                <tr>
                    <td><b><a href="{{ route('managePositions_SelectPosition', [$pb['ID'], $viewName]) }}">{{$pb->Title}}</a></b></td>
                    <td>{{$pb->PositionStatus}}</td>
                    <form method="post" action={{"/backlog_assignToSprint/".$pb['ID']}} enctype="multipart/form-data">
                        @csrf
                        <td><select name="backlog_selectedSprint">
                                <option value="">-</option>
                                @foreach($all_open_sprints as $aos)
                                <option value="{{$aos['ID']}}" @if($aos['ID'] == $pb['sprintID']) selected @endif >{{$aos['sprint_name']}} </option>
                                @endforeach
                            </select>                            
                        </td>
                        <td><input type="submit" name="edit" value="Assign to sprint" /></td>
                    </form>
                </tr>
                
    @endforeach
    </table>
@else
    <div class="miniheader-subContents">
        <h5>No positions available</h5>
    </div>    
@endif


@stop