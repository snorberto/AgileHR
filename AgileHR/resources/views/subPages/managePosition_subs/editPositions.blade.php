@extends("subPages.managePosition")
@section("managePositionSubContent")

<div class="miniheader-subContents">
    <h3>Edit selected position</h3>
</div>

<table class="formTable">
    <form method="post" action=/{{"managePosition_updateSelectedPosition/".$data['ID']}} enctype="multipart/form-data">
    @csrf
        <tr>            
            <td><b>Title</b></td>
            <td><input type="text" name="pos_title" value="{{ $data->Title }}" /></td>
            <td><b>Status</b></td>
            <td><select name="selected_pos_status">
                        <option value="">-</option>
                        @foreach($pos_status as $pos_stat)
                        <option value="{{$pos_stat['ID']}}" @if($pos_stat['ID'] == $data['position_status']) selected @endif >{{$pos_stat['PositionStatus']}} </option>
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
@stop