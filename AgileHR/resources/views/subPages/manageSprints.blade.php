@extends("mainSite.index")	 
@section("content")

<div class="header-subContents">
    <h1>Manage sprints</h1>
</div>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif
<br>
<div class="navigation-subContents">
    <a href="/getOpenSprints">List of open sprints</a>
    <a href="/createSprint">Create new sprint</a>
    <a href="/getClosedSprints">List of closed sprints</a>
</div>

<div class="row">
    <div>    
        @yield("manageSprintSubContent")
    </div>
</div>
@stop