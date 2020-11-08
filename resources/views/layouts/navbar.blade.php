<?php
use Illuminate\Support\Facades\Auth;
?>
<ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link mt-1" data-widget="pushmenu" href="javascript:" role="button">
			<i class="fas fa-bars"></i>
		</a>
	</li>
	<li class="nav-item d-none d-sm-inline-block">
		<a href="{{ url('/') }}" data-turbolinks-action="replace" class="nav-link">Beranda</a>
	</li>
</ul>
<ul class="navbar-nav ml-auto">
	<!--li class="nav-item">
		<a href="javascript:" class="nav-link">
			<i class="far fa-lg fa-bell"></i>
		</a>
	</li-->
	<li class="nav-item dropdown user-menu">
		<a href="javascript:" class="nav-link dropdown-toggle" data-toggle="dropdown">
			<i class="user-image fa fa-2x fa-user-circle"></i>
			<span class="d-none d-md-inline">{{ Auth::user()->level }}</span>
		</a>
		<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
			<li class="user-header bg-primary">
				<p>{{ Auth::user()->name }}</p>
			</li>
			<!--li class="user-body"></li-->
			<li class="user-footer">
				<a href="{{ url('/setting-profile') }}" data-turbolinks-action="replace" class="btn btn-primary btn-flat">Profile</a>
				<form action="{{ url('/logout') }}" method="POST" class="d-inline">
					@csrf
					<button class="btn btn-danger btn-flat float-right">Sign out</button>
				</form>
			</li>
		</ul>
	</li>
</ul>