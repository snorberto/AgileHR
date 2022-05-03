@extends("mainSite.index")	 
@section("content")

<div class="header-subContents">
    <h1>Candidate manager</h1>
</div>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif

<br>
<div class="navigation-subContents">
    <a href="/createCandidate">Add new candidate profile</a>
    <a href="/getAllCandidates">List of all candidates</a>
    <a href="/searchForCandidates">Search for candidate</a>
    <a href="/maintainLabels">Maintain candidate labels</a>
    <a href="/maintainContactInfo">Maintain contact information types</a>
    @if (Auth::user()->isAdmin == 1 || Auth::user()->RoleID == 4)
    <a href="/maintainCandidateStatus">Maintain candidate enrollment statuses</a>
    @endif


</div>

<div class="row">
    <div>    
        @yield("manageCandidateSubContent")
    </div>
</div>
@stop