@section("header")
<div class="topnav">
  <p>Recruit Partner</p> 
  @guest <a href="/login" class="loginlink">Login</a> @endguest
  @auth  <a href="/logout" class="loginlink">Log out</a> @endauth
</div>