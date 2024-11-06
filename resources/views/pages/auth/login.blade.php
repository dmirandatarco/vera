<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Sistema de Zolux">
		<meta name="Author" content="David Miranda Tarco">
		<meta name="Keywords" content="Vera Importaciones"/>

		<!-- Title -->
		<title> Vera Importaciones </title>

		<!-- Favicon -->
		<link rel="icon" href="{{ asset('img/brand/favicon.png') }}" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="{{ asset('css/icons.css') }}" rel="stylesheet">

		<!--  bootstrap css-->
		<link id="style" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

		<!--- Style css --->
		<link href="{{ asset('css/style.css')}}" rel="stylesheet">
		<link href="{{ asset('css/style-dark.css')}}" rel="stylesheet">
		<link href="{{ asset('css/style-transparent.css')}}" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="{{ asset('css/skin-modes.css')}}" rel="stylesheet" />

		<!--- Animations css-->
		<link href="{{ asset('css/animate.css')}}" rel="stylesheet">

	</head>
	<body class="ltr error-page1 bg-primary">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<div class="square-box">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
		<div class="page" >
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
							<div class="card-sigin">
                                <!-- Demo content-->
                                <div class="main-card-signin d-md-flex justify-content-center">
                                    <div class="wd-100p"><div class="d-flex mb-4 justify-content-center"><a href="index.html"><img src="{{asset('img/brand/favicon-black.png')}}" class="sign-favicon ht-80" alt="logo"></a></div>
                                        <div class="">
											<div class="main-signup-header">
												<h2>Bienvenido</h2>
												<h6 class="font-weight-semibold mb-4">Por favor inicia sesion.</h6>
												<div class="panel panel-primary">
                                                    <form method="post" action="{{route('login')}}">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label>Usuario</label>
                                                            <input type="text" class="form-control" id="userEmail" placeholder="Usuario" name="usuario">
                                                            @error('usuario')
                                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Password</label>
                                                            <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password"  name="password">
                                                            @error('password')
                                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <button class="btn btn-primary btn-block">Iniciar Sesion</button>
                                                    </form>
											    </div>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>

		<!-- JQuery min js -->
		<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>

		<!-- Bootstrap js -->
		<script src="{{ asset('plugins/bootstrap/js/popper.min.js')}}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>

		<!-- Moment js -->
		<script src="{{ asset('plugins/moment/moment.js')}}"></script>

		<!-- eva-icons js -->
		<script src="{{ asset('js/eva-icons.min.js')}}"></script>


		<!--Internal  Perfect-scrollbar js -->
		<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

		<!-- Theme Color js -->
		<script src="{{ asset('js/themecolor.js')}}"></script>

		<!-- custom js -->
		<script src="{{ asset('js/custom.js')}}"></script>

	</body>
</html>