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
<br>
<div class="navigation-subContents">
    <a href="/createCandidate">Add new candidate profile</a>
    <a href="/getAllCandidates">List of all candidates</a>
    <a href="/searchForCandidates">Search for candidate</a>
    <a href="/maintainLabels">Maintain candidate labels</a>
    <a href="/maintainContactInfo">Maintain contact information types</a>

</div>

<div class="row">
    <div>    
        @yield("manageCandidateSubContent")
    </div>
</div>
@stop