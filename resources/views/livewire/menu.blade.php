@if( request()->is('pages/css/*') )
<li class="nav-item">
    <a href="{{ route('css-results', ['param' => 2024]) }}" class="nav-link {{ request()->is('pages/css/results/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>CSM Results</p>
    </a>
</li>
<li class="nav-item">
	<a href="{{ route('list-css-responses') }}" class="nav-link {{ request()->is('pages/css/responses/*') ? 'active' : '' }}">
		<i class="nav-icon far fa-file-alt"></i>
		<p>Responses</p>
	</a>
</li>
<li class="nav-header">Account Settings</li>
<li class="nav-item">
	<a href="#" class="nav-link">
  		<i class="nav-icon fas fa-user"></i>
  		<p>User Profile</p>
	</a>
</li>
<li class="nav-item">
	<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
	  	<i class="nav-icon fas fa-sign-out-alt"></i>
	  	<p>Logout</p>
	</a>
	<form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
	    @csrf
	</form>
</li>
@elseif( request()->is('pages/document-tracking/*') )
<li class="nav-item">
	<a href="{{ route('document-tracking-dashboard') }}" class="nav-link {{ request()->is('pages/document-tracking/dashboard') ? 'active' : '' }}">
		<i class="nav-icon fas fa-chart-bar"></i>
		<p>Dashboard</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('list-documents') }}" class="nav-link {{ request()->is('pages/document-tracking/list-documents') ? 'active' : '' }}">
		<i class="nav-icon far fa-file-alt"></i>
		<p>Documents</p>
	</a>
</li>
<li class="nav-header">Account Settings</li>
<li class="nav-item">
	<a href="#" class="nav-link">
  		<i class="nav-icon fas fa-user"></i>
  		<p>User Profile</p>
	</a>
</li>
<li class="nav-item">
	<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
	  	<i class="nav-icon fas fa-sign-out-alt"></i>
	  	<p>Logout</p>
	</a>
	<form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
	    @csrf
	</form>
</li>
@elseif( request()->is('pages/ict-request/*') )
<li class="nav-item">
	<a href="{{ route('ict-request-dashboard') }}" class="nav-link {{ request()->is('pages/ict-request/dashboard') ? 'active' : '' }}">
		<i class="nav-icon fas fa-chart-bar"></i>
		<p>Dashboard</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('list-ict-requests') }}" class="nav-link {{ request()->is('pages/ict-request/list-ict-requests') ? 'active' : '' }}">
		<i class="nav-icon far fa-file-alt"></i>
		<p>ICT Requests</p>
	</a>
</li>
<li class="nav-header">Account Settings</li>
<li class="nav-item">
	<a href="#" class="nav-link">
  		<i class="nav-icon fas fa-user"></i>
  		<p>User Profile</p>
	</a>
</li>
<li class="nav-item">
	<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
	  	<i class="nav-icon fas fa-sign-out-alt"></i>
	  	<p>Logout</p>
	</a>
	<form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
	    @csrf
	</form>
</li>
@elseif( request()->is('pages/issuance/*') )
<li class="nav-item">
	<a href="" class="nav-link">
		<i class="nav-icon fas fa-chart-bar"></i>
		<p>Dashboard</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('list-issuances') }}" class="nav-link {{ request()->is('pages/issuance/list-issuances') ? 'active' : '' }}">
		<i class="nav-icon far fa-file-alt"></i>
		<p>Issuances</p>
	</a>
</li>
<li class="nav-header">Account Settings</li>
<li class="nav-item">
	<a href="#" class="nav-link">
  		<i class="nav-icon fas fa-user"></i>
  		<p>User Profile</p>
	</a>
</li>
<li class="nav-item">
	<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
	  	<i class="nav-icon fas fa-sign-out-alt"></i>
	  	<p>Logout</p>
	</a>
	<form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
	    @csrf
	</form>
</li>
@else
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ request()->is('pages/home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-item">
	<a href="{{ route('module-selector') }}" class="nav-link {{ request()->is('pages/module-selector') ? 'active' : '' }}">
		<i class="nav-icon fas fa-cubes"></i>
		<p>Modules</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('calendar') }}" class="nav-link {{ request()->is('pages/calendar') ? 'active' : '' }}">
		<i class="nav-icon fas fa-calendar"></i>
		<p>Calendar of Activities</p>
	</a>
</li>
@if( Auth::user()->userlevel_id == 1 )
<li class="nav-header">Admin Menu</li>
	<li class="nav-item">
		<a href="{{ route('list-users') }}" class="nav-link {{ request()->is('pages/admin/list-users') ? 'active' : '' }}">
			<i class="nav-icon fas fa-users"></i>
			<p>Users</p>
		</a>
	</li>
	<li class="nav-item">
		<a href="{{ route('references') }}" class="nav-link {{ request()->is('pages/admin/references') ? 'active' : '' }}">
			<i class="nav-icon fas fa-book"></i>
			<p>References</p>
		</a>
	</li>
	<li class="nav-item">
		<a href="{{ route('settings') }}" class="nav-link {{ request()->is('pages/admin/settings') ? 'active' : '' }}">
			<i class="fas fa-cog nav-icon"></i>
			<p>Settings</p>
		</a>
	</li>
@endif
<li class="nav-header">Account Settings</li>
<li class="nav-item">
	<a href="#" class="nav-link">
  		<i class="nav-icon fas fa-user"></i>
  		<p>User Profile</p>
	</a>
</li>
<li class="nav-item">
	<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
	  	<i class="nav-icon fas fa-sign-out-alt"></i>
	  	<p>Logout</p>
	</a>
	<form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
	    @csrf
	</form>
</li>
@endif
