@extends("subPages.manageCandidate")
@section("manageCandidateSubContent")


<div class="miniheader-subContents">
    <h3>All candidates</h3>
</div>
<div class="activitySite-subContents">
@if(!$candidates->isEmpty())
    <table class="formTable">
        <tr>
            <th>Name</th>
            <th>Attachment</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Operation</th>
        </tr>
        @foreach($candidates as $c)
        <tr>
            <td><a href=#>{{$c['Name']}}</a></td>
            <td>@if(!is_null($c['Attachments']))<a href="{{ URL::to('/') }}/attachments/candidate_cvs/{{ $c['Attachments'] }}">Attachment</a>@else No attachments found @endif</td>
            <td>{{$c['created_at']}}</td>
            <td>{{$c['updated_at']}}</td>
            <td>
                <a href={{"manageCandidate_deleteSelectedCandidate/".$c['ID']}}>Delete Candidate</a>
                <br>
                <a href={{"manageCandidate_SelectCandidate/".$c['ID']}}>Edit Candidate</a> 
            </td>       
        </tr>
        @endforeach
    </table>
@else 
    <div class="miniheader-subContents">
        <h5>No candidates available.</h5>
    </div>
@endif
</div>
@stop