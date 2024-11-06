<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
    Route::post('/', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/perfil/{user}', 'App\Http\Controllers\UserController@perfil')->name('perfil');
    Route::patch('perfilguardar/{user}', 'App\Http\Controllers\UserController@perfilguardar')->name('perfilguardar');
    Route::resource('configuracion/user', App\Http\Controllers\UserController::class)->names('user');
    Route::resource('configuracion/roles', App\Http\Controllers\RoleController::class)->except('show')->names('roles');
    Route::get('configuracion/categoria/ordenar/', 'App\Http\Controllers\CategoriaController@ordenar')->name('categoria.ordenar');
    Route::post('categoria/guardarordenar/', 'App\Http\Controllers\CategoriaController@guardarordenar')->name('categoria.guardarordenar');
    Route::resource('configuracion/categoria', App\Http\Controllers\CategoriaController::class)->names('categoria');
    Route::post('categoria/editprice/','App\Http\Controllers\CategoriaController@editprice')->name('categoria.editprice');
    Route::resource('configuracion/sucursal', App\Http\Controllers\SucursalController::class)->names('sucursal');
    Route::resource('/movimientos/merma', App\Http\Controllers\MermaController::class)->names('merma');
    Route::resource('configuracion/almacen', App\Http\Controllers\AlmacenController::class)->names('almacen');
    Route::resource('/movimientos/tipo', App\Http\Controllers\TipoController::class)->names('tipo');
    Route::get('ventas/producto/editpricemassive/', 'App\Http\Controllers\ProductoController@editpricemassive')->name('producto.editpricemassive');
    Route::post('producto/editpricemassivestore/', 'App\Http\Controllers\ProductoController@editpricemassivestore')->name('producto.editpricemassivestore');
    Route::resource('ventas/producto', App\Http\Controllers\ProductoController::class)->names('producto');
    Route::get('ventas/producto-buscar', 'App\Http\Controllers\ProductoController@buscar')->name('producto.buscar');
    Route::get('movimientos/producto-excel', [App\Http\Controllers\ProductoController::class,'producto_excel'])->name('productoexcel');
    Route::post('ventas/producto-cargamasiva', [App\Http\Controllers\ProductoController::class,'cargamasiva'])->name('producto.cargamasiva');
    Route::get('movimientos/createmovimientomasivo/', 'App\Http\Controllers\MovimientoController@createmovimientomasivo')->name('movimiento.createmovimientomasivo');
    Route::get('/movimientos/plantillaexcelcrear/', 'App\Http\Controllers\MovimientoController@plantillaexcelcrear')->name('movimiento.plantillaexcelcrear');
    Route::get('/ventas/ticketpdf/{venta}', 'App\Http\Controllers\VentaController@ticketpdf')->name('venta.ticketpdf');
    Route::get('/ventas/ticketpedido/{venta}', 'App\Http\Controllers\VentaController@ticketpedido')->name('venta.ticketpedido');
    Route::post('ventas/procesarseleccion', 'App\Http\Controllers\VentaController@procesarSeleccion')->name('ventas.procesarSeleccion');
    Route::get('/pagoanular/{id}', 'App\Http\Controllers\VentaController@pagoanular')->name('ventas.pagoanular');
    Route::get('/cobraranular/{id}', 'App\Http\Controllers\VentaController@cobraranular')->name('ventas.cobraranular');
    Route::get('/ventas/consulta/{id}', 'App\Http\Controllers\VentaController@getVentaById')->name('ventas.getVentaById');
    Route::get('/ventas/consultatrabajo/{id}', 'App\Http\Controllers\VentaController@getTrabajoById')->name('ventas.getTrabajoById');
    Route::get('/cobrar/cobrar', 'App\Http\Controllers\VentaController@cobrar')->name('ventas.cobrar');
    Route::post('/venta-pagar', 'App\Http\Controllers\VentaController@pagar')->name('ventas.pagar');
    Route::post('/venta-pagar-global', 'App\Http\Controllers\VentaController@pagarglobal')->name('ventas.pagarglobal');
    Route::post('/cobrar-pagar', 'App\Http\Controllers\VentaController@cobrarTrabajador')->name('ventas.cobrarTrabajador');
    Route::post('/cobrar-pagar-global', 'App\Http\Controllers\VentaController@pagarglobalTrabajador')->name('ventas.pagarglobalTrabajador');
    Route::post('/cobrar-juntarcajas', 'App\Http\Controllers\VentaController@juntarcajas')->name('venta.juntarcajas');
    Route::get('/cajas/caja-reporte', 'App\Http\Controllers\CajaController@reporte')->name('caja.reporte');
    Route::get('/ventas/ordentrabajo', 'App\Http\Controllers\VentaController@ordentrabajo')->name('venta.ordentrabajo');
    Route::post('/ordentrabajoguardar', 'App\Http\Controllers\VentaController@ordentrabajoguardar')->name('venta.ordentrabajoguardar');
    Route::post('/caja-cerrar', 'App\Http\Controllers\CajaController@cerrar')->name('caja.cerrar');
    Route::post('/caja-pagos', 'App\Http\Controllers\CajaController@pagos')->name('caja.pagos');
    Route::post('/cajacobros-cerrar', 'App\Http\Controllers\CajaCobrarController@cerrar')->name('cajacobrar.cerrar');
    Route::post('/user-cambiar', 'App\Http\Controllers\UserController@cambiar')->name('user.cambiar');
    Route::delete('/destroyorden', 'App\Http\Controllers\VentaController@destroyorden')->name('venta.destroyorden');

    Route::get('/facturacion/facturacion-notas', 'App\Http\Controllers\FacturacionController@facturaciontrabajo')->name('facturacion.notaventa');
    Route::post('facturacion/facturaciontrabajoguardar', 'App\Http\Controllers\FacturacionController@facturaciontrabajoguardar')->name('facturacion.facturaciontrabajoguardar');
    Route::get('/facturacion/facturacion', 'App\Http\Controllers\FacturacionController@listado')->name('facturacion.listado');
    Route::get('/descargar-xml/{id}', 'App\Http\Controllers\FacturacionController@descargarXml')->name('facturacion.xml');
    Route::delete('/destroyfactura', 'App\Http\Controllers\FacturacionController@destroyfactura')->name('facturacion.destroyfactura');
    Route::get('/facturacion/enviar/{venta}', 'App\Http\Controllers\FacturacionController@enviarfactura')->name('facturacion.enviarfactura');
    Route::get('facturacion/reporte', 'App\Http\Controllers\FacturacionController@reporte')->name('facturacion.reporte');

    Route::get('reportes/mermas-pdf', 'App\Http\Controllers\MermaController@mermaspdf')->name('merma.mermas-pdf');
    Route::get('reportes/mermas-excel', 'App\Http\Controllers\MermaController@mermasexcel')->name('merma.mermas-excel');

    Route::get('reportes/ventas', 'App\Http\Controllers\ReporteController@ventas')->name('reportes.ventas');
    Route::get('reportes/ventas-pdf', 'App\Http\Controllers\ReporteController@ventaspdf')->name('reportes.ventas-pdf');
    Route::get('reportes/ventas-excel', 'App\Http\Controllers\ReporteController@ventasexcel')->name('reportes.ventas-excel');
    Route::get('reportes/ventasproductos', 'App\Http\Controllers\ReporteController@ventasproductos')->name('reportes.ventas-productos');
    Route::get('reportes/ventasproductos-pdf', 'App\Http\Controllers\ReporteController@ventasproductospdf')->name('reportes.ventas-productos-pdf');
    Route::get('reportes/ventasproductos-excel', 'App\Http\Controllers\ReporteController@ventasproductosexcel')->name('reportes.ventas-productos-excel');
    Route::get('reportes/ventasserie', 'App\Http\Controllers\ReporteController@ventasseries')->name('reportes.ventas-series');
    Route::get('reportes/ventasserie-pdf', 'App\Http\Controllers\ReporteController@ventasseriespdf')->name('reportes.ventas-series-pdf');
    Route::get('reportes/ventasserie-excel', 'App\Http\Controllers\ReporteController@ventasseriesexcel')->name('reportes.ventas-series-excel');
    Route::get('reportes/biselados', 'App\Http\Controllers\ReporteController@biselados')->name('reportes.biselados');
    Route::get('reportes/biselados-pdf', 'App\Http\Controllers\ReporteController@biseladospdf')->name('reportes.biselados-pdf');
    Route::get('reportes/biselados-excel', 'App\Http\Controllers\ReporteController@biseladosexcel')->name('reportes.biselados-excel');

    Route::resource('movimientos', App\Http\Controllers\MovimientoController::class)->except('show')->names('movimiento');
    Route::resource('movimientos/proveedor', App\Http\Controllers\ProveedorController::class)->names('proveedor');
    Route::get('/compras/ticketpdf/{compra}', 'App\Http\Controllers\CompraController@ticketpdf')->name('compra.ticketpdf');
    Route::get('compras/tickets', 'App\Http\Controllers\CompraController@tickets')->name('compra.tickets');
    Route::post('/ticketguardar', 'App\Http\Controllers\CompraController@ticketguardar')->name('compra.ticketguardar');
    Route::delete('/destroyticket', 'App\Http\Controllers\CompraController@destroyticket')->name('compra.destroyticket');
    Route::get('/compras/consultatticket/{id}', 'App\Http\Controllers\CompraController@getTicketById')->name('compra.getTicketById');
    Route::get('/compras/consulta/{id}', 'App\Http\Controllers\CompraController@getCompraById')->name('compra.getCompraById');
    Route::get('/pagocompraanular/{id}', 'App\Http\Controllers\CompraController@anularpago')->name('compra.anularpago');
    Route::post('/compra-pagar', 'App\Http\Controllers\CompraController@pagar')->name('compra.pagar');

    Route::get('ventas/editar-trabajo/{id}', 'App\Http\Controllers\VentaController@editartrabajo')->name('venta.editartrabajo');
    Route::resource('ventas', App\Http\Controllers\VentaController::class)->except('show')->names('venta');
    Route::resource('compras', App\Http\Controllers\CompraController::class)->except('show')->names('compra');
    Route::resource('ventas/cliente', App\Http\Controllers\ClienteController::class)->names('cliente');
    Route::resource('configuracion/maquina', App\Http\Controllers\MaquinaController::class)->names('maquina');
    Route::resource('configuracion/medio', App\Http\Controllers\MedioController::class)->names('medio');
    Route::resource('cajas/caja', App\Http\Controllers\CajaController::class)->names('caja');
    Route::resource('cobrar/cajacobrar', App\Http\Controllers\CajaCobrarController::class)->names('cajacobrar');

    Route::get('/consultatableproductos', 'App\Http\Controllers\ProductoController@consultatableproductos');
    Route::get('/movimientos/informesexcel/{movimiento}', 'App\Http\Controllers\MovimientoController@informesexcel')->name('movimiento.informesexcel');

    Route::group(['prefix' => 'error'], function () {
        Route::get('404', function () {
            return view('pages.error.404');
        });
        Route::get('500', function () {
            return view('pages.error.500');
        });
    });
});

