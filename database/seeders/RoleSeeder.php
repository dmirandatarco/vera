<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Administrador']);
        // $role2 = Role::create(['name' => 'Recepcion']);
        // $role3 = Role::create(['name' => 'Trabajador']);
        // $role4 = Role::create(['name' => 'Cobrador']);

        // $role = Role::where('name', 'Administrador')->first();
        Permission::create(['name'=>'dashboard','description'=>'Visualizar Dashboard','modulo'=>'Configuracion'])->assignRole($role);
        Permission::create(['name'=>'user.index','description'=>'Ver Listado de Usuarios','modulo'=>'Usuario'])->assignRole($role);
        Permission::create(['name'=>'user.edit','description'=>'Editar Usuario','modulo'=>'Usuario'])->assignRole($role);
        Permission::create(['name'=>'user.create','description'=>'Crear Usuario','modulo'=>'Usuario'])->assignRole($role);
        Permission::create(['name'=>'user.destroy','description'=>'Eliminar Usuario','modulo'=>'Usuario'])->assignRole($role);
        Permission::create(['name'=>'user.show','description'=>'Ver información Usuario','modulo'=>'Usuario'])->assignRole($role);
        Permission::create(['name'=>'role.index','description'=>'Ver la lista de Roles','modulo'=>'Roles'])->assignRole($role);
        Permission::create(['name'=>'role.edit','description'=>'Editar Rol','modulo'=>'Roles'])->assignRole($role);
        Permission::create(['name'=>'role.destroy','description'=>'Cambiar de estado Rol','modulo'=>'Roles'])->assignRole($role);
        Permission::create(['name'=>'role.create','description'=>'Crear Rol','modulo'=>'Roles'])->assignRole($role);
        Permission::create(['name'=>'categoria.index','description'=>'Ver Listado de Categorias','modulo'=>'Categoria'])->assignRole($role);
        Permission::create(['name'=>'categoria.edit','description'=>'Editar Categoria','modulo'=>'Categoria'])->assignRole($role);
        Permission::create(['name'=>'categoria.editprice','description'=>'Editar Precio por Categoria','modulo'=>'Categoria'])->assignRole($role);
        Permission::create(['name'=>'categoria.create','description'=>'Crear Categoria','modulo'=>'Categoria'])->assignRole($role);
        Permission::create(['name'=>'categoria.destroy','description'=>'Eliminar Categoria','modulo'=>'Categoria'])->assignRole($role);
        Permission::create(['name'=>'sucursal.index','description'=>'Ver Listado de Sucursales','modulo'=>'Sucursal'])->assignRole($role);
        Permission::create(['name'=>'sucursal.edit','description'=>'Editar Sucursal','modulo'=>'Sucursal'])->assignRole($role);
        Permission::create(['name'=>'sucursal.create','description'=>'Crear Sucursal','modulo'=>'Sucursal'])->assignRole($role);
        Permission::create(['name'=>'sucursal.destroy','description'=>'Eliminar Sucursal','modulo'=>'Sucursal'])->assignRole($role);
        Permission::create(['name'=>'merma.index','description'=>'Ver Listado de Mermas','modulo'=>'Merma'])->assignRole($role);
        Permission::create(['name'=>'merma.edit','description'=>'Editar Merma','modulo'=>'Merma'])->assignRole($role);
        Permission::create(['name'=>'merma.create','description'=>'Crear Merma','modulo'=>'Merma'])->assignRole($role);
        Permission::create(['name'=>'merma.destroy','description'=>'Eliminar Merma','modulo'=>'Merma'])->assignRole($role);
        Permission::create(['name'=>'almacen.index','description'=>'Ver Listado de Almacenes','modulo'=>'Almacen'])->assignRole($role);
        Permission::create(['name'=>'almacen.edit','description'=>'Editar Almacen','modulo'=>'Almacen'])->assignRole($role);
        Permission::create(['name'=>'almacen.create','description'=>'Crear Almacen','modulo'=>'Almacen'])->assignRole($role);
        Permission::create(['name'=>'almacen.destroy','description'=>'Eliminar Almacen','modulo'=>'Almacen'])->assignRole($role);
        Permission::create(['name'=>'tipo.index','description'=>'Ver Listado de Tipo de Movimientos','modulo'=>'Tipo de Movimiento'])->assignRole($role);
        Permission::create(['name'=>'tipo.edit','description'=>'Editar Tipo de Movimiento','modulo'=>'Tipo de Movimiento'])->assignRole($role);
        Permission::create(['name'=>'tipo.create','description'=>'Crear Tipo de Movimiento','modulo'=>'Tipo de Movimiento'])->assignRole($role);
        Permission::create(['name'=>'tipo.destroy','description'=>'Eliminar Tipo de Movimiento','modulo'=>'Tipo de Movimiento'])->assignRole($role);
        Permission::create(['name'=>'producto.index','description'=>'Ver Listado de Productos','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'producto.edit','description'=>'Editar Producto','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'producto.create','description'=>'Crear Producto','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'producto.destroy','description'=>'Eliminar Producto','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'producto.editarmasivo','description'=>'Editar Masivo','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'producto.subirarchivo','description'=>'Subir Productos Archivo','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'producto.stock','description'=>'Agregar Stock a Producto','modulo'=>'Producto'])->assignRole($role);
        Permission::create(['name'=>'proveedor.index','description'=>'Ver Listado de Proveedores','modulo'=>'Proveedor'])->assignRole($role);
        Permission::create(['name'=>'proveedor.edit','description'=>'Editar Proveedor','modulo'=>'Proveedor'])->assignRole($role);
        Permission::create(['name'=>'proveedor.create','description'=>'Crear Proveedor','modulo'=>'Proveedor'])->assignRole($role);
        Permission::create(['name'=>'proveedor.destroy','description'=>'Eliminar Proveedor','modulo'=>'Proveedor'])->assignRole($role);
        Permission::create(['name'=>'movimiento.index','description'=>'Ver Listado de Movimiento','modulo'=>'Movimiento'])->assignRole($role);
        Permission::create(['name'=>'movimiento.edit','description'=>'Editar Movimiento','modulo'=>'Movimiento'])->assignRole($role);
        Permission::create(['name'=>'movimiento.create','description'=>'Crear Movimiento','modulo'=>'Movimiento'])->assignRole($role);
        Permission::create(['name'=>'movimiento.destroy','description'=>'Eliminar Movimiento','modulo'=>'Movimiento'])->assignRole($role);
        Permission::create(['name'=>'movimiento.show','description'=>'Ver Informacion de Movimiento','modulo'=>'Movimiento'])->assignRole($role);
        Permission::create(['name'=>'movimiento.plantilla','description'=>'Generar Plantilla de Movimiento','modulo'=>'Movimiento'])->assignRole($role);
        Permission::create(['name'=>'cliente.index','description'=>'Ver Listado de Cliente','modulo'=>'Cliente'])->assignRole($role);
        Permission::create(['name'=>'cliente.edit','description'=>'Editar Cliente','modulo'=>'Cliente'])->assignRole($role);
        Permission::create(['name'=>'cliente.create','description'=>'Crear Cliente','modulo'=>'Cliente'])->assignRole($role);
        Permission::create(['name'=>'cliente.destroy','description'=>'Eliminar Cliente','modulo'=>'Cliente'])->assignRole($role);
        Permission::create(['name'=>'maquina.index','description'=>'Ver Listado de Maquina','modulo'=>'Maquina'])->assignRole($role);
        Permission::create(['name'=>'maquina.edit','description'=>'Editar Maquina','modulo'=>'Maquina'])->assignRole($role);
        Permission::create(['name'=>'maquina.create','description'=>'Crear Maquina','modulo'=>'Maquina'])->assignRole($role);
        Permission::create(['name'=>'maquina.destroy','description'=>'Eliminar Maquina','modulo'=>'Maquina'])->assignRole($role);
        Permission::create(['name'=>'medio.index','description'=>'Ver Listado de Medio de Pago','modulo'=>'Medio'])->assignRole($role);
        Permission::create(['name'=>'medio.edit','description'=>'Editar Medio de Pago','modulo'=>'Medio'])->assignRole($role);
        Permission::create(['name'=>'medio.create','description'=>'Crear Medio de Pago','modulo'=>'Medio'])->assignRole($role);
        Permission::create(['name'=>'medio.destroy','description'=>'Eliminar Medio de Pago','modulo'=>'Medio'])->assignRole($role);
        Permission::create(['name'=>'caja.index','description'=>'Ver Listado de Cajas','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'caja.edit','description'=>'Editar Caja','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'caja.create','description'=>'Aperturar Caja','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'caja.cerrar','description'=>'Cerrar Caja','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'caja.ingreso','description'=>'Agregar Ingreso','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'caja.egreso','description'=>'Agregar Egreso','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'caja.reporte','description'=>'Reporte Caja','modulo'=>'Caja'])->assignRole($role);
        Permission::create(['name'=>'cajacobrar.index','description'=>'Aperturar Caja Cobrar','modulo'=>'Caja Cobrar'])->assignRole($role);
        Permission::create(['name'=>'venta.index','description'=>'Ver Listado de Venta','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'venta.edit','description'=>'Editar Venta','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'venta.create','description'=>'Crear Venta','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'venta.destroy','description'=>'Eliminar Venta','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'venta.cobrar', 'description' => 'Cobrar Ventas', 'modulo' => 'Venta'])->assignRole([$role]);
        Permission::create(['name'=>'venta.anularcobrar', 'description' => 'Anular Cobro', 'modulo' => 'Venta'])->assignRole([$role]);
        Permission::create(['name'=>'venta.facturar','description'=>'Facturar Venta','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'venta.anularpago','description'=>'Anular Pago','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'venta.ordentrabajo','description'=>'Ordenes de Trabajo','modulo'=>'Venta'])->assignRole($role);
        Permission::create(['name'=>'reportes.ventas','description'=>'Ver Reporte de Venta','modulo'=>'Reporte'])->assignRole($role);
        Permission::create(['name'=>'reportes.ventas-productos','description'=>'Ver Reporte de Venta por productos','modulo'=>'Reporte'])->assignRole($role);
        Permission::create(['name'=>'compra.index','description'=>'Ver Listado de Compra','modulo'=>'Compra'])->assignRole($role);
        Permission::create(['name'=>'compra.edit','description'=>'Editar Compra','modulo'=>'Compra'])->assignRole($role);
        Permission::create(['name'=>'compra.create','description'=>'Crear Compra','modulo'=>'Compra'])->assignRole($role);
        Permission::create(['name'=>'compra.destroy','description'=>'Eliminar Compra','modulo'=>'Compra'])->assignRole($role);
        Permission::create(['name'=>'compra.tickets', 'description' => 'Ver Tickets', 'modulo' => 'Compra'])->assignRole([$role]);
        Permission::create(['name'=>'compra.anularpago', 'description' => 'Anular pago de Compra', 'modulo' => 'Compra'])->assignRole([$role]);
        Permission::create(['name'=>'facturacion.notaventa','description'=>'Crear Facturacion de notas de venta','modulo'=>'Facturacion'])->assignRole($role);
        Permission::create(['name'=>'facturacion.listado', 'description' => 'Ver Lista de Facturas', 'modulo' => 'Facturacion'])->assignRole([$role]);
        Permission::create(['name'=>'reportes.ventas-series','description'=>'Ver Reporte de Venta por series','modulo'=>'Reporte'])->assignRole($role);
        Permission::create(['name'=>'reportes.biselados','description'=>'Ver Reporte de Biselados','modulo'=>'Reporte'])->assignRole($role);


    }
}
