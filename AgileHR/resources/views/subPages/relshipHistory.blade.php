@extends("mainSite.index")	 
@section("content")

<div class="header-subContents">
    <h1>Position history</h1>
</div>
@if($history->count()>0)
    <table class="formTable">
        <tr>
            <th>Candidate Name</th>
            <th>Candidate's status</th>
            <th>Position's status at update </th>
            <th>Assignee</th>
            <th>Comment</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
        @foreach($history as $h)
            <tr>
                <td>{{$h->Name}}</td>
                <td>{{$h->CandidateStatus}}</td>
                <td>{{$h->PositionStatus}}</td>
                @if(!is_null($h->username))
                    <td>{{$h->username}}</td>
                @else
                    <td>-</td>
                @endif
                @if(!is_null($h->Comment))
                    <td>{{$h->Comment}}</td>
                @else
                    <td>-</td>
                @endif
                <td>{{$h->created_at}}</td>
                <td>{{$h->updated_at}}</td>
            </tr>
        @endforeach
    </table>
@else
<div class="header-subContents">
    <h3>No entries found</h3>
</div>
@endif
@stop