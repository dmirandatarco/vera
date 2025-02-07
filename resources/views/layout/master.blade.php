<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Sistema de Zolux">
		<meta name="Author" content="David Miranda Tarco">
		<meta name="Keywords" content="Sistema de Zolux"/>

		<!-- Title -->
		<title> Zolux - Sistema de Zolux </title>

		<!-- Favicon -->

		<link rel="icon" href="{{ asset('img/brand/favicon.png') }}" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="{{ asset('css/icons.css') }}" rel="stylesheet">

		<!--  bootstrap css-->
		<link id="style" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

		<!-- style css -->
		<link href="{{ asset('css/style.css')}}" rel="stylesheet">
		<link href="{{ asset('css/style-dark.css')}}" rel="stylesheet">
		<link href="{{ asset('css/style-transparent.css')}}" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="{{ asset('css/skin-modes.css')}}" rel="stylesheet" />

		<!--- Animations css-->
		<link href="{{ asset('css/animate.css')}}" rel="stylesheet">

        @stack('plugin-styles')
        @stack('style')
        @livewireStyles

	</head>

	<body class="ltr main-body app sidebar-mini">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div>
				@include('layout.header')

				@include('layout.sidebar')
			</div>


			<!-- main-content -->
			<div class="main-content app-content">
                @yield('content')

			</div>
			<!-- /main-content -->

			@include('layout.footer')

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
        @livewireScripts
		<!-- JQuery min js -->
		<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>

		<!-- Bootstrap js -->
		<script src="{{ asset('plugins/bootstrap/js/popper.min.js')}}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>

		<!--Internal  Perfect-scrollbar js -->
		<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

		<!-- Sidebar js -->
		<script src="{{ asset('plugins/side-menu/sidemenu.js')}}"></script>

		<script src="{{ asset('js/eva-icons.min.js')}}"></script>

		<!-- Sticky js -->
    	<script src="{{ asset('js/sticky.js')}}"></script>


		<!-- Theme Color js -->
		<script src="{{ asset('js/themecolor.js')}}"></script>

		<!-- custom js -->
		<script src="{{ asset('js/custom.js')}}"></script>


		<!-- <script>
			// Selecciona todos los inputs
			var inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
		
			// Asigna el evento a cada input
			inputs.forEach(function(input) {
				input.addEventListener('mouseover', function() {
					seleccionarTexto(input);
				});

				input.addEventListener('focus', function() {
					seleccionarTexto(input);
				});

				input.setAttribute('autocomplete', 'off');
			});
			
		
			function seleccionarTexto(input) {
				input.select();
			}

		</script> -->


        @stack('plugin-scripts')
        @stack('custom-scripts')

	</body>
</html>
