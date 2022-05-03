@extends("mainSite.index")	 
@section("content")

<div class="header-subContents">
    <h1>Position manager</h1>
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
    <a href="/createPosition">Create new position</a>
    <a href="/getAllpositions">List of open positions</a>
    <a href="/searchPosition">Search for position</a>
    @if(Auth::user()->isAdmin == 1 || Auth::user()->RoleID == 4)
    <a href="/maintainPositionStatus">Maintain position statuses</a>
    @endif
</div>

<div class="row">
    <div>    
        @yield("managePositionSubContent")
    </div>
</div>
@stop