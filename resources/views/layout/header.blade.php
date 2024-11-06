<!-- main-header -->
<div class="main-header side-header sticky nav nav-item">
	<div class=" main-container container-fluid">
		<div class="main-header-left ">
			<div class="responsive-logo">
				{{-- <a href="index.html" class="header-logo">
					<img src="{{ asset('img/brand/logo.png')}}" class="mobile-logo logo-1" alt="logo">
					<img src="{{ asset('img/brand/logo-white.png')}}" class="mobile-logo dark-logo-1" alt="logo">
				</a> --}}
			</div>
			<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
				<a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left" ></i></a>
				<a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
			</div>
			<div class="logo-horizontal">
				{{-- <a href="index.html" class="header-logo">
					<img src="{{ asset('img/brand/logo.png')}}" class="mobile-logo logo-1" alt="logo">
					<img src="{{ asset('img/brand/logo-white.png')}}" class="mobile-logo dark-logo-1" alt="logo">
				</a> --}}
			</div>
		</div>
		<div class="main-header-right">
			<button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon fe fe-more-vertical "></span>
			</button>
			<div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
				<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
					<ul class="nav nav-item header-icons navbar-nav-right ms-auto">
						@if(\Auth::user()->roles[0]->name == 'Administrador')
							<li class="nav-item ">
								<a type="button" class="new nav-link " data-bs-toggle="modal" data-bs-target="#cambiarSucursal"><svg class="header-icon-svgs"  xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/></svg></a>
							</li>
						@endif
                        <li class="dropdown nav-item">
                            <a class="new nav-link theme-layout nav-link-bg layout-setting" >
                                <span class="dark-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"/></svg></span>
                                <span class="light-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"/></svg></span>
                            </a>
                        </li>
						<li class="nav-item full-screen fullscreen-button">
							<a class="new nav-link full-screen-link" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"/></svg></a>
						</li>


						<li class="nav-link search-icon d-lg-none d-block">
							<form class="navbar-form" role="search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search">
									<span class="input-group-btn">
										<button type="reset" class="btn btn-default">
											<i class="fas fa-times"></i>
										</button>
										<button type="submit" class="btn btn-default nav-link resp-btn">
											<svg xmlns="http://www.w3.org/2000/svg" height="24px" class="header-icon-svgs" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
										</button>
									</span>
								</div>
							</form>
						</li>
						<li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">
							<a class="new nav-link profile-user d-flex" href="" data-bs-toggle="dropdown"><img alt="" src="{{ asset('img/faces/2.jpg')}}" class=""></a>
							<div class="dropdown-menu">
								<div class="menu-header-content p-3 border-bottom">
									<div class="d-flex wd-100p">
										<div class="main-img-user"><img alt="" src="{{ asset('img/faces/2.jpg')}}" class=""></div>
										<div class="ms-3 my-auto">
											<h6 class="tx-15 font-weight-semibold mb-0">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</h6>
											<span class="dropdown-title-text subtext op-6  tx-12">{{Auth::user()->roles[0]->name}}</span>
										</div>
									</div>
								</div>
								{{-- <a class="dropdown-item" href="{{route('perfil',Auth::user())}}"><i class="far fa-user-circle"></i>Perfil</a> --}}
								<a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="far fa-arrow-alt-circle-left"></i> Cerrar Sesión</a>
							</div>
						</li>
					</ul>
					<form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /main-header -->

<div class="modal fade" id="cambiarSucursal" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >Cambiar Estado </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
				</div>
			<div class="modal-body">
				<form action="{{route('user.cambiar','test')}}" method="POST" autocomplete="off">
				{{csrf_field()}} 
					<div class="mb-3 col-md-12" >
						<label class="form-label" for="sucursal_id">Sucursal</label>
						<select class="js-example-basic-single form-select" id="sucursal_id" name="sucursal_id" data-width="100%">
							<option value="" @selected(old('sucursal_id')=="")>SELECCIONE</option>
							@foreach(\App\Models\Sucursal::all() as $sucursal)
							<option value="{{$sucursal->id}}" @selected($sucursal->id ==  \Auth::user()->sucursal_id)>{{$sucursal->nombre}}</option>
							@endforeach
						</select>
						@error('sucursal_id')
							<span class="error-message" style="color:red">{{ $message }}</span>
						@enderror
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Aceptar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('plugin-scripts')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
@endpush

@push('custom-scripts')
<script>
	$('#sucursal_id').select2({
        width: '100%',
		dropdownParent: $('#cambiarSucursal')
    });
</script>
@endpush