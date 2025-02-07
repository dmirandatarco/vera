<!-- main-sidebar -->
<div class="sticky">
	<aside class="app-sidebar">
		<div class="main-sidebar-header active">
			<a class="header-logo active" href="index.html">
				<img src="{{ asset('img/brand/logo.png')}}" class="main-logo  desktop-logo" alt="logo">
				<img src="{{ asset('img/brand/logo-white.png')}}" class="main-logo  desktop-dark" alt="logo">
				<img src="{{ asset('img/brand/favicon.png')}}" class="main-logo  mobile-logo" alt="logo">
				<img src="{{ asset('img/brand/favicon-white.png')}}" class="main-logo  mobile-dark" alt="logo">
			</a>
		</div>
		<div class="main-sidemenu">
			<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
			<ul class="side-menu">
				<li class="side-item side-item-category">Menu</li>
				@can('dashboard')
                    <li class="slide">
                        <a class="side-menu__item {{request()->routeIs(['dashboard','welcome']) ? 'active': ''}}" href="{{ url('/') }}">
                            <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/></svg><span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                @endcan

                {{-- @if ( Gate::check('user.index') ||  Gate::check('roles.index') ||  Gate::check('categoria.index') ||  Gate::check('sucursal.index') ||  Gate::check('almacen.index') ||  Gate::check('medio.index') ||  Gate::check('maquina.index'))
                    <li class="slide {{ Str::startsWith(request()->path(), 'configuracion') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'configuracion') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><g><path d="M0,0h24v24H0V0z" fill="none"/><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></g></svg><span class="side-menu__label">Configuracion</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            @can('user.index')
                                <li><a class="slide-item {{request()->routeIs(['user.*']) ? 'active': ''}}" href="{{ route('user.index') }}" >Usuarios</a></li>
                            @endcan
                            @can('role.index')
                                <li><a class="slide-item {{request()->routeIs(['roles.*']) ? 'active': ''}}" href="{{ route('roles.index') }}"  >Roles</a></li>
                            @endcan
                            @can('categoria.index')
                                <li><a class="slide-item {{request()->routeIs(['categoria.*']) ? 'active': ''}}"  href="{{ route('categoria.index') }}">Categorias</a></li>
                            @endcan
                            @can('sucursal.index')
                                <li><a class="slide-item {{request()->routeIs(['sucursal.*']) ? 'active': ''}}"  href="{{ route('sucursal.index') }}">Sucursales</a></li>
                            @endcan
                            @can('almacen.index')
                                <li><a class="slide-item {{request()->routeIs(['almacen.*']) ? 'active': ''}}"  href="{{ route('almacen.index') }}">Almacenes</a></li>
                            @endcan
                            @can('medio.index')
                                <li><a class="slide-item {{request()->routeIs(['medio.*']) ? 'active': ''}}"  href="{{ route('medio.index') }}">Medios de Pago</a></li>
                            @endcan
                            @can('maquina.index')
                                <li><a class="slide-item {{request()->routeIs(['maquina.*']) ? 'active': ''}}"  href="{{ route('maquina.index') }}">Maquina</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif --}}
                @if ( Gate::check('venta.create') ||  Gate::check('venta.index') ||  Gate::check('cliente.index') ||  Gate::check('producto.index') )
                    <li class="slide {{ Str::startsWith(request()->path(), 'ventas') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'ventas') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-8.9-5h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4l-3.87 7H8.53L4.27 2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2z"/>
                            </svg><span class="side-menu__label">Ventas</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('venta.create')
                                <li><a class="slide-item {{request()->routeIs(['venta.create']) ? 'active': ''}}" href="{{ route('venta.create') }}" >Crear Venta</a></li>
                            @endcan
                            @can('venta.index')
                                <li><a class="slide-item {{request()->routeIs(['venta.index']) ? 'active': ''}}" href="{{ route('venta.index') }}"  >Ventas</a></li>
                            @endcan
                            {{-- @can('venta.ordentrabajo')
                                <li><a class="slide-item {{request()->routeIs(['venta.ordentrabajo']) ? 'active': ''}}" href="{{ route('venta.ordentrabajo') }}"  >Ordenes de Trabajo</a></li>
                            @endcan --}}
                            @can('cliente.index')
                                <li><a class="slide-item {{request()->routeIs(['cliente.*']) ? 'active': ''}}"  href="{{ route('cliente.index') }}">Clientes</a></li>
                            @endcan
                            @can('producto.index')
                                <li><a class="slide-item {{request()->routeIs(['producto.*']) ? 'active': ''}}"  href="{{ route('producto.index') }}">Productos</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif
                {{-- @if ( Gate::check('compra.create') ||  Gate::check('compra.index') ||  Gate::check('compra.tickets'))
                    <li class="slide {{ Str::startsWith(request()->path(), 'compras') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'compras') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none"/><path d="M17.21 9l-4.38-6.56c-.19-.28-.51-.42-.83-.42-.32 0-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1h-4.79zM9 9l3-4.4L15 9H9zm3 8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                            </svg><span class="side-menu__label">Compras</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('compra.create')
                                <li><a class="slide-item {{request()->routeIs(['compra.create']) ? 'active': ''}}" href="{{ route('compra.create') }}" >Crear Compra</a></li>
                            @endcan
                            @can('compra.index')
                                <li><a class="slide-item {{request()->routeIs(['compra.index']) ? 'active': ''}}" href="{{ route('compra.index') }}"  >Compras</a></li>
                            @endcan
                            @can('compra.tickets')
                                <li><a class="slide-item {{request()->routeIs(['compra.tickets']) ? 'active': ''}}" href="{{ route('compra.tickets') }}"  >Tickets</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif --}}

                {{-- @if ( Gate::check('movimiento.index') ||  Gate::check('proveedor.index') ||  Gate::check('merma.index') ||  Gate::check('tipo.index') )
                    <li class="slide {{ Str::startsWith(request()->path(), 'movimientos') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'movimientos') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/>
                            </svg><span class="side-menu__label">Movimientos</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('movimiento.index')
                                <li><a class="slide-item {{request()->routeIs(['movimiento.*']) ? 'active': ''}}" href="{{ route('movimiento.index') }}" >Movimientos </a></li>
                            @endcan
                            @can('proveedor.index')
                                <li><a class="slide-item {{request()->routeIs(['proveedor.*']) ? 'active': ''}}"  href="{{ route('proveedor.index') }}">Proveedores</a></li>
                            @endcan
                            @can('merma.index')
                                <li><a class="slide-item {{request()->routeIs(['merma.*']) ? 'active': ''}}"  href="{{ route('merma.index') }}">Merma</a></li>
                            @endcan
                            @can('tipo.index')
                                <li><a class="slide-item {{request()->routeIs(['tipo.*']) ? 'active': ''}}"  href="{{ route('tipo.index') }}">Tipos de Movimientos</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif --}}

                @if ( Gate::check('caja.index') ||  Gate::check('caja.reporte') )
                    <li class="slide {{ Str::startsWith(request()->path(), 'cajas') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'cajas') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <g><path d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12.88,17.76V19h-1.75v-1.29 c-0.74-0.18-2.39-0.77-3.02-2.96l1.65-0.67c0.06,0.22,0.58,2.09,2.4,2.09c0.93,0,1.98-0.48,1.98-1.61c0-0.96-0.7-1.46-2.28-2.03 c-1.1-0.39-3.35-1.03-3.35-3.31c0-0.1,0.01-2.4,2.62-2.96V5h1.75v1.24c1.84,0.32,2.51,1.79,2.66,2.23l-1.58,0.67 c-0.11-0.35-0.59-1.34-1.9-1.34c-0.7,0-1.81,0.37-1.81,1.39c0,0.95,0.86,1.31,2.64,1.9c2.4,0.83,3.01,2.05,3.01,3.45 C15.9,17.17,13.4,17.67,12.88,17.76z"/></g>                            </svg><span class="side-menu__label">Caja</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('caja.index')
                                <li><a class="slide-item {{request()->routeIs(['caja.index']) ? 'active': ''}}" href="{{ route('caja.index') }}" >Lista Caja </a></li>
                            @endcan
                            @can('caja.reporte')
                                <li><a class="slide-item {{request()->routeIs(['caja.reporte']) ? 'active': ''}}"  href="{{ route('caja.reporte') }}">Reporte Caja</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- @if ( Gate::check('venta.cobrar') ||  Gate::check('cajacobrar.index') )
                    <li class="slide {{ Str::startsWith(request()->path(), 'cobrar') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'cobrar') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                            </svg><span class="side-menu__label">Caja Cobrar</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('cajacobrar.index')
                                <li><a class="slide-item {{request()->routeIs(['cajacobrar.index']) ? 'active': ''}}" href="{{ route('cajacobrar.index') }}" >Lista Caja </a></li>
                            @endcan
                            @can('venta.cobrar')
                                <li><a class="slide-item {{request()->routeIs(['ventas.cobrar']) ? 'active': ''}}"  href="{{ route('ventas.cobrar') }}">Ventas por Cobrar</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif --}}
                {{-- @if ( Gate::check('reportes.ventas') || Gate::check('reportes.ventas-productos') || Gate::check('reportes.ventas-series') || Gate::check('reportes.biselados'))
                    <li class="slide {{ Str::startsWith(request()->path(), 'reportes') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'reportes') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                        </svg><span class="side-menu__label">Reportes</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('reportes.ventas')
                                <li><a class="slide-item {{request()->routeIs(['reportes.ventas']) ? 'active': ''}}" href="{{ route('reportes.ventas') }}" >Ventas </a></li>
                            @endcan
                            @can('reportes.ventas-productos')
                                <li><a class="slide-item {{request()->routeIs(['reportes.ventas-productos']) ? 'active': ''}}" href="{{ route('reportes.ventas-productos') }}" >Ventas por Producto</a></li>
                            @endcan
                            @can('reportes.ventas-series')
                                <li><a class="slide-item {{request()->routeIs(['reportes.ventas-series']) ? 'active': ''}}" href="{{ route('reportes.ventas-series') }}" >Ventas por Serie</a></li>
                            @endcan
                            @can('reportes.biselados')
                                <li><a class="slide-item {{request()->routeIs(['reportes.biselados']) ? 'active': ''}}" href="{{ route('reportes.biselados') }}" >Biselados</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif --}}
                @if ( Gate::check('facturacion.notaventa') || Gate::check('facturacion.listado') )
                    <li class="slide {{ Str::startsWith(request()->path(), 'facturacion') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Str::startsWith(request()->path(), 'facturacion') ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M20,3H4C2.9,3,2,3.9,2,5v14c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V5 C22,3.9,21.1,3,20,3z M10,17H5v-2h5V17z M10,13H5v-2h5V13z M10,9H5V7h5V9z M14.82,15L12,12.16l1.41-1.41l1.41,1.42L17.99,9 l1.42,1.42L14.82,15z" fill-rule="evenodd"/>
                        </svg><span class="side-menu__label">Facturación</span><i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            <!-- @can('facturacion.notaventa')
                                <li><a class="slide-item {{request()->routeIs(['facturacion.notaventa']) ? 'active': ''}}" href="{{ route('facturacion.notaventa') }}" >Facturar Nota de Ventas </a></li>
                            @endcan -->
                            @can('facturacion.listado')
                                <li><a class="slide-item {{request()->routeIs(['facturacion.listado']) ? 'active': ''}}" href="{{ route('facturacion.listado') }}" >Facturación</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif
			</ul>
			<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
		</div>
	</aside>
</div>
<!-- main-sidebar -->
