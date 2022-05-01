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
    <a href="/createPosition">Create new position</a>
    <a href="/getAllpositions">List of open positions</a>
    <a href="/searchPosition">Search for position</a>
</div>

<div class="row">
    <div>    
        @yield("managePositionSubContent")
    </div>
</div>
@stop