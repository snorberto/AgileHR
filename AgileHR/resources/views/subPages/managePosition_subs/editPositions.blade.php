@extends("subPages.managePosition")
@section("managePositionSubContent")

<div class="miniheader-subContents">
    <h3>Edit selected position</h3>
</div>

<table class="formTable">
    <tr>
        <td colspan=2><b><a href=/{{"relship_showHistory/".$data['ID']}}>View position History</a></b></td>
        @if(is_null($relship))
            <td colspan=2>Cannot set position to Closed, no suitable candidate yet.</td>
        @else        
            <td colspan=2><b><a href="{{ route('relship_closePosition', [$data['ID'], $view]) }}">Close position</a></b></td>
            
        @endif
    </tr>
    <form method="post" action=/{{"managePosition_updateSelectedPosition/".$data['ID']}} enctype="multipart/form-data">
    @csrf
        <input type="hidden" name="editPos_siteName" value="{{$view}}" />
        <tr>            
            <td><b>Title</b></td>
            <td><input type="text" name="pos_title" value="{{ $data->Title }}" /></td>
            <td><b>Status</b></td>
            <td><select name="selected_pos_status">
                        <option value="">-</option>
                        @foreach($pos_status as $pos_stat)
                            @if($pos_stat['ID'] == 4 && !is_null($relship))
                                <option value="{{$pos_stat['ID']}}" @if($pos_stat['ID'] == $data['position_status']) selected @endif >{{$pos_stat['PositionStatus']}} </option>
                            @elseif($pos_stat['ID'] == 4 && is_null($relship))
                                @continue
                            @else
                                <option value="{{$pos_stat['ID']}}" @if($pos_stat['ID'] == $data['position_status']) selected @endif >{{$pos_stat['PositionStatus']}} </option>
                            @endif       

                        @endforeach
                </select></td>
        </tr>
        <tr>
            <td><b>Reporter:</b></td>
            <td>{{ $data['username'] }}</td>
            <td><b>Assignee</b></td>
            <td><select name="selectedAssignee">
                        <option value="">-</option>
                        @foreach($usernames as $u)
                        <option value="{{$u['ID']}}" @if($u['ID'] == $data['assignee_id']) selected @endif >{{$u['username']}} </option>
                        @endforeach
                </select></td>
        </tr>
        <tr>
            <td><b>Created At</b></td>
            <td>{{$data['created_at']}}</td>
            <td><b>Last updated on</b></td>
            <td>{{$data['updated_at']}}</td>
        </tr>
        <tr>
            <td><b>Sprint</b></td>
            <td><select name="selectedSprint">
                        <option value="">-</option>
                        @foreach($sprints as $s)
                        <option value="{{$s['ID']}}" @if($s['ID'] == $data['sprint_id']) selected @endif >{{$s['sprint_name']}} </option>
                        @endforeach
                </select></td>
            <td><b>Story points</b></td>
            <td><input type="text" name="pos_storypoint" @if(is_null($data['story_points'])) value=0 @else value="{{ $data['story_points']}}" @endif />
        </tr>
        <tr>
            <td colspan=4><b>Description</b></td>
        </tr>
        <tr>
            <td colspan=4><textarea name=pos_description rows=12 cols=100>{{$data['Description']}}</textarea></td>
        </tr>
        <tr>
            <td colspan=4><b>Attachment</b></td>
        </tr>
        <tr>
            <td colspan=4>@if(!is_null($data['attachment']))<a href="{{ URL::to('/') }}/attachments/positions/{{ $data['attachment'] }}">Attachment</a>@else No attachments found</td>@endif
        </tr>
        <tr>
            <td colspan=2><b>Update attachment<br>(docx and pdf accepted only!)</b></td>
            <td colspan=2><input type="file" name="pos_attachment"/></td>
        </tr>
        <tr>
            <td colspan=4><input type="submit" name="edit" value="Edit" /></td>
        </tr>


    </form>
</table>

<div class="miniheader-subContents">
    <h3>Candidates that applied to the position</h3>
</div>
@if($latestEntries->count() > 0)
    <table class="formTable">
        <tr>
            <td colspan=7><b>Candidates</b></td>            
        </tr>
        <tr>
            <th>Candidate Name</th>
            <th>Candidate's status</th>
            <th>Position's status at update </th>
            <th>Assignee</th>
            <th>Comment</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>

            @foreach($latestEntries as $le)
                <tr>
                    <td>{{$le->Name}}</td>
                    <td>{{$le->CandidateStatus}}</td>
                    <td>{{$le->PositionStatus}}</td>
                    @if(!is_null($le->username))
                        <td>{{$le->username}}</td>
                    @else
                        <td>-</td>
                    @endif
                    @if(!is_null($le->Comment))
                        <td>{{$le->Comment}}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{$le->created_at}}</td>
                    <td>{{$le->updated_at}}</td>                    
                </tr>
            @endforeach
    </table>
@else
    <div class="miniheader-subContents">
        <h5>No candidates applied yet.</h5>
    </div>
@endif
@if($candidate_list->count() > 0)
<form method="post" action=/{{"Relationships_addNew/".$data['ID']}} enctype="multipart/form-data">
    @csrf
        <input type="hidden" name="editPos_siteName" value="{{$view}}" />
        <table class="formTable">
            <tr>
                <td colspan=6><b>Add new status change</b></td>
            </tr>
            <tr>
                <td><b>Select candidate</b></td>
                <td>
                    <select name="relship_add_candidate_select">                            
                            @foreach($candidate_list as $c)
                                <option value="{{$c['ID']}}">{{$c['Name']}} </option>
                            @endforeach
                    </select>
                </td>
                <td><b>Select position status</b></td>
                <td>
                    <select name="relship_selected_pos_status">
                            @foreach($pos_status as $pos_stat)
                                @if($pos_stat['ID'] == 4 && !is_null($relship))
                                    <option value="{{$pos_stat['ID']}}" @if($pos_stat['ID'] == $data['position_status']) selected @endif >{{$pos_stat['PositionStatus']}} </option>
                                @elseif($pos_stat['ID'] == 4 && is_null($relship))
                                    @continue
                                @else
                                    <option value="{{$pos_stat['ID']}}" @if($pos_stat['ID'] == $data['position_status']) selected @endif >{{$pos_stat['PositionStatus']}} </option>
                                @endif
                            @endforeach
                    </select>
                </td>
                <td><b>Select candidate status</b></td>
                <td>
                    <select name="relship_add_candidate_status_select">                            
                            @foreach($can_status as $c)
                                <option value="{{$c['ID']}}">{{$c['CandidateStatus']}} </option>
                            @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Comment</b></td>
                <td colspan=5><input type="text" name="relship_comment" size=50/></td>
            </tr>
            <tr>
                <td colspan=6><input type="submit" name="add" value="Add entry" /></td>
            </tr>
        </table>
</form>
@else
    <div class="miniheader-subContents">
        <h5>No candidates created yet.</h5>
    </div>
@endif
@stop