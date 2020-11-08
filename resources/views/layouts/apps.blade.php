<html>
<head>
	@include('layouts.head')
	
	<style>
	.info-box-border{border-left:4px solid}
	</style>	
	
	@include('layouts.scripts')
	
	<livewire:styles>
	<livewire:scripts>
	
	<script src="{{ asset('dist/js/turbolinks.js') }}"></script>
	<script src="{{ asset('dist/js/alpine.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			@include('layouts.navbar')
		</nav>
		<aside class="main-sidebar sidebar-light-primary elevation-4">
			@include('layouts.sidebar')
		</aside>
		<div class="content-wrapper bg-light">
			<div class="content-header">
				<div class="container-fluid">
					<ol class="breadcrumb">
					
					</ol>
				</div>
			</div>
			<section class="content">
				<div class="container-fluid">
					<div class="row" id="AjaxcontentloaD">
					@yield('content')
					</div>
				</div>
			</section>
		</div>
		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<b>Version</b> 1.0.0
			</div>
			<strong>Copyright POS</strong> All rights reserved.
		</footer>
	</div>
	<script src="{{ asset('dist/js/app.js') }}"></script>
	<script>
	$('body').Layout('fixLayoutHeight');
	Turbolinks.start();
	</script>
</body>
</html>