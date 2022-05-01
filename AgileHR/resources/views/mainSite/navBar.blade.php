@section("navBar")
<div class="vertical-menu">
  
  @auth    
    <a href="/activeSprintView">Active sprint board</a>
    <a href="#">Backlog view</a>
    @if (Auth::user()->isAdmin == 1)
    <a href="/manageUsers">Manage users</a>
    @endif
    @if (Auth::user()->isAdmin == 1 || Auth::user()->RoleID == 4)
    <a href="/manageSprints">Manage Sprints</a>
    @endif
    <a href="/managePosition">Position manager</a>
    <a href="#">Create new candidate entry</a>
  @endauth

</div>