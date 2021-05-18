
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Transmetro</title>

	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">


	<!-- Font Awesome JS -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


	<style type="text/css">

		@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


		.wrapper {
			display: flex;
			align-items: stretch;
		}

		#sidebar {
			min-width: 250px;
			max-width: 250px;
		}

		#sidebar.active {
			margin-left: -250px;
		}
		#sidebar {
			min-width: 250px;
			max-width: 250px;
			min-height: 100vh;
		}
		.amplio {
			margin-right: 10px;
  			margin-left: 20px;
		width: 100%	

		}
		
		body {
			font-family: 'Poppins', sans-serif;
			background: #fafafa;
		}

		p {
			font-family: 'Poppins', sans-serif;
			font-size: 1.1em;
			font-weight: 300;
			line-height: 1.7em;
			color: #999;
		}

		a, a:hover, a:focus {
			color: inherit;
			text-decoration: none;
			transition: all 0.3s;
		}

		#sidebar {
			/* don't forget to add all the previously mentioned styles here too */
			background: #555555;
			color: #fff;
			transition: all 0.3s;
		}

		#sidebar .sidebar-header {
			padding: 20px;
			background: #6d7fcc;
		}

		#sidebar ul.components {
			padding: 20px 0;
			border-bottom: 1px solid #45D55A;
		}

		#sidebar ul p {
			color: #fff;
			padding: 10px;
		}

		#sidebar ul li a {
			padding: 10px;
			font-size: 1.1em;
			display: block;
		}
		#sidebar ul li a:hover {
			color: #7386D5;
			background: #fff;
		}

		#sidebar ul li.active > a, a[aria-expanded="true"] {
			color: #fff;
			background: #666666;
		}
		ul ul a {
			font-size: 0.9em !important;
			padding-left: 30px !important;
			background: #45D55A;
		}

	</style>	

</head>

<body>
	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<!-- Popper.JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

	<div id="app" class="wrapper">
		<!-- Sidebar -->
		<nav id="sidebar">
					
			<ul class="list-unstyled components">
				<a class="active"  href="{{ url('/') }}">
					<center><H2>TRANSMETRO</H2></center>
				</a>

				<li>
					<a href="#formularios" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">FORMULARIOS</a>
					<ul class="collapse list-unstyled" id="formularios">
						<a href="{{route('municipios.index')}}">MUNICIPIOS</a>	
						<a href="{{route('rolles.index')}}">ROLLES</a>
						<a href="{{route('estaciones.index')}}">ESTACIONES</a>
						<a href="{{route('empleados.index')}}">EMPLEADOS</a>	
						<a href="{{route('parqueos.index')}}">PARQUEOS</a>
					</ul>
				</li>
				<li>
				<a href="#reportes" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">REPORTES</a>
					<ul class="collapse list-unstyled" id="reportes">
						<a href="{{route('rutas.index')}}">RUTAS</a>
						<a href="{{route('recorridos.index')}}">RECORRIDOS</a>
				</li>
			</ul>
			
		</nav>
			
	<!-- Page Content -->
	<div id="content" class="amplio">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<button type="button" id="sidebarCollapse" class="btn btn-info">
					<i class="fas fa-align-left"></i>
					<span>MENU</span>
				</button>
			</div>
			<div>
				@guest
				<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
				@if (Route::has('register'))
				<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
				@endif
				@else

				
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						{{ Auth::user()->name }}
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				
				@endguest
			
			</div>
		</nav>


		

	<main >
			@yield('content')
	</main>
</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#sidebarCollapse').on('click', function () {
				$('#sidebar').toggleClass('active');
			});
		});
	</script>
</body>
</html>