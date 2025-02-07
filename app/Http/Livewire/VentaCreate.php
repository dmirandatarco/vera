<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use Livewire\Component;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Company as ModelsCompany;
use App\Models\Cuota;
use App\Models\DetalleTrabajo;
use App\Models\DetalleVenta;
use App\Models\Documento;
use App\Models\DocumentoSunat;
use App\Models\Medio;
use App\Models\Pago;
use App\Models\Stock;
use App\Models\Trabajo;
use App\Models\User;
use App\Models\Venta;
use App\Services\SunatService;
use Illuminate\Support\Facades\Http;
use DB;
use Carbon\Carbon;
use Greenter\Report\XmlUtils;

class VentaCreate extends Component
{
    public $tipo_documento=1;
    public $clienteId=1;
    public $clientes;
    public $usuarios;
    public $precioProducto;
    public $cantidadProducto;
    public $contDetalles = -1;

    public $nuevotipo_documento;
    public $nuevodocumento;
    public $nuevonombrecomercial;
    public $nuevonombrerazon;
    public $nuevotelefono;
    public $nuevodireccion;
    public $nuevocorreo;
    public $nuevozona;
    public $nuevotipocliente="PROVINCIA";

    public $tipo=1;
    public $cuotas;
    public $fechacuota;
    public $total=0;

    public $cont = 0;
    public $search;

    public $issearchClienteEmpty = false;
    public $productos = [];
    public $detalleProductos  =[];

    public $documento;

    public $mensaje = '';
    public $searchDocumento;

    public $nombrerazon;

    public $numedoc1;
    public $medioId=1;
    public $totalpago=0;
    public $medios;
    public $documentos;

    public $productoId;
    public $precio;
    public $cantidad;
    public $eje;
    public $subtotal;
    public $isEdit;

    public $tipoventa = 0;
    public $dip=0;
    public $add=0;
    public $usermaquina;

    public $cantidadproductos=0;
    public $idTrabajoEdit;
    public $idVentaEdit;
    public $cantidad_final=1;

    public function mount($trabajo = null, $venta = null)
    {
        $this->clientes = Cliente::where('estado',1)->get();
        $this->medios = Medio::where('estado',1)->get();
        $this->documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->where('nombre','!=','FACTURA ELECTRÓNICA')->get();
        $this->usuarios = User::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->get();
        if($trabajo){
            $this->idTrabajoEdit = $trabajo->id;
            $this->clienteId = $trabajo->cliente_id;
            $this->usermaquina = $trabajo->user_id;
            foreach($trabajo->detallesTrabajos as $detalletra){
                $this->dip = $detalletra->dip;
                $this->add = $detalletra->add;
                $detalle = [
                    'cantidad' => $detalletra->cantidad,
                    'productoId' => $detalletra->producto_id,
                    'productonombre' => $detalletra->producto->nombre.'-'.$detalletra->producto->categoria->nombre.'-'.$detalletra->producto->categoria->abreviatura.'-'.$detalletra->producto->serie->nombre,
                    'precio' => $detalletra->precio,
                    'subtotal' => $detalletra->precio*$detalletra->cantidad,
                    'eje' => $detalletra->eje,
                ];
                $this->detalleProductos[] = $detalle;
            }
            $this->calcularTotal();
        }else{
            $this->tipoventa = 0 ;
        }
        if($venta){
            $this->idVentaEdit = $venta->id; 
            $this->tipo_documento = $venta->documento_id;
            $this->tipo = $venta->pago;
            $this->cuotas = $venta->cuotas()->count();
            if($this->cuotas > 0){
                foreach($venta->cuotas as $i => $cuota){
                    $this->fechacuota[$i] = $cuota->fecha;
                }
            }
            if($trabajo){
            }else{
                $this->clienteId = $venta->cliente_id;
                foreach($venta->detallesVenta as $detalleven){
                    $this->dip = $detalleven->dip;
                    $this->add = $detalleven->add;
                    $detalle = [
                        'cantidad' => $detalleven->cantidad,
                        'productoId' => $detalleven->producto_id,
                        'productonombre' => $detalleven->producto->nombre.'-'.$detalleven->producto->categoria->nombre.'-'.$detalleven->producto->categoria->abreviatura.'-'.$detalleven->producto->serie->nombre,
                        'precio' => $detalleven->precio,
                        'subtotal' => $detalleven->precio*$detalleven->cantidad,
                        'eje' => $detalleven->eje,
                    ];
                    $this->detalleProductos[] = $detalle;
                }
                $this->calcularTotal();
            }
        }
        if(!$trabajo && !$venta){
            $this->tipoventa = 1 ;
        }
    }

    public function agregarCliente()
    {
        $this->validate([
            'nuevotipo_documento' => 'required',
            'nuevodocumento' => 'required|max:15',
            'nuevonombrerazon' => 'required|max:250',
            'nuevonombrecomercial' => 'required|max:250',
            'nuevodireccion' => 'nullable|max:255',
            'nuevotelefono' => 'nullable|max:50',
            'nuevocorreo' => 'nullable|email|max:250',
        ]);

        $cliente=Cliente::create([
            'documento' => $this->nuevotipo_documento,
            'num_documento' => $this->nuevodocumento,
            'razon_social' => $this->nuevonombrerazon,
            'nombre_comercial' => $this->nuevonombrecomercial,
            'telefono' => $this->nuevotelefono,
            'direccion' => $this->nuevodireccion,
            'correo' => $this->nuevocorreo,
            'tipo' => $this->nuevotipocliente,
            'zona' => $this->nuevozona,
            'sunat' => $this->nuevotipo_documento == 'DNI' ? '1':'6',
        ]);
        $this->clientes = Cliente::where('estado',1)->get();
        session()->flash('danger', 'Cliente agregado Correctamente.');
        $this->emit('close-modal',$cliente->id);
    }

    public function searchDocumento()
    {
        if ($this->nuevotipo_documento == 'DNI') {
            $cliente = Cliente::where('num_documento', $this->nuevodocumento)->first();
            if ($cliente) {
                $this->nuevonombrerazon = $cliente->razon_social;
                $this->nuevonombrecomercial = $cliente->razon_social;
                $this->nuevotelefono = $cliente->telefono;
                $this->nuevodireccion = $cliente->direccion;
                $this->nuevocorreo = $cliente->correo;
                $this->nuevotipocliente = $cliente->tipo;
                $this->nuevozona = $cliente->zona;
                $this->mensaje = '';
            } else {
                $this->searchDNIInAPI($this->nuevodocumento);
                $this->mensaje = $cliente?->razon_social ? '' : 'Este cliente no está registrado en nuestra base de datos DNI';
            }
        } elseif ($this->nuevotipo_documento == 'RUC') {
            $cliente = Cliente::where('num_documento', $this->nuevodocumento)->first();
            if ($cliente) {
                $this->nuevonombrerazon = $cliente->razon_social;
                $this->nuevonombrecomercial = $cliente->razon_social;
                $this->nuevotelefono = $cliente->telefono;
                $this->nuevodireccion = $cliente->direccion;
                $this->nuevocorreo = $cliente->correo;
                $this->nuevotipocliente = $cliente->tipo;
                $this->nuevozona = $cliente->zona;
                $this->mensaje = '';
            } else {
                $this->searchRUCInAPI($this->nuevodocumento);
                $this->mensaje = $cliente?->razon_social ? '' : 'Este cliente no está registrado en nuestra base de datos RUC';
            }
        }
    }

    public function searchInAPI($documento)
    {
        $length = strlen($documento);
        if ($length == 8) {
            $this->searchDNIInAPI($documento);
        } elseif ($length == 11) {
            $this->searchRUCInAPI($documento);
        } else {
            session()->flash('success', 'El número de documento debe tener 8 o 11 dígitos');
            $this->mensaje = '';
        }
    }

    public function searchDNIInAPI($dni)
    {
        $token = config('services.apisunat.token');
        $urldni = config('services.apisunat.urldni');
        $host = 'api.apis.net.pe';
        if (gethostbyname($host) == $host) {
            session()->flash('success', 'No hay conexión a Internet. Por favor, verifica tu conexión y vuelve a intentarlo.');
            $this->mensaje = '';
        } else {
            try {
                $response = Http::timeout(10)->withHeaders([
                    'Referer' => 'http://apis.net.pe/api-ruc',
                    'Authorization' => 'Bearer ' . $token
                ])->get($urldni . $dni);
                $persona = ($response->json());
                if (isset($persona['error']) || $persona == "") {
                    $this->numedoc1 = $dni;
                    if (isset($persona['error'])) {

                        session()->flash('success', 'Se necesita 8 digitos');
                        $this->nuevonombrerazon ="";
                        $this->nuevonombrecomercial = "";
                        $this->nuevodireccion = '';
                        $this->mensaje ="";
                    }
                    if ($persona == "") {
                        session()->flash('success', 'No se encontro datos');
                        $this->mensaje="";
                    }
                    $this->mensaje="";
                } else {
                    $this->mensaje ="";
                    $this->nuevonombrerazon = $persona['nombre'];
                    $this->nuevonombrecomercial = $persona['nombre'];
                    $this->nuevodireccion = $persona['direccion'];
                }
            } catch (RequestException $e) {
                if ($e->getCode() === CURLE_OPERATION_TIMEOUTED) {
                    session()->flash('success', 'Se ha superado el límite de tiempo de la solicitud. Por favor, inténtalo de nuevo más tarde.');
                    $this->mensaje = '';
                } else {
                    session()->flash('success', 'Ocurrió un error al consumir la API:');
                    $this->mensaje = '';
                }
            }
        }
    }

    public function searchRUCInAPI($ruc)
    {
        $token = config('services.apisunat.token');
        $urlruc = config('services.apisunat.urlruc');
        $host = 'api.apis.net.pe';

        if (gethostbyname($host) == $host) {
            session()->flash('success', 'No hay conexión a Internet. Por favor, verifica tu conexión y vuelve a intentarlo.');
            $this->mensaje = '';
        } else {
            try {
                $response = Http::timeout(10)->withHeaders([
                    'Referer' => 'http://apis.net.pe/api-ruc',
                    'Authorization' => 'Bearer ' . $token
                ])->get($urlruc . $ruc);

                $persona = ($response->json());

                if ($persona == "" || isset($persona['error'])) {
                    $this->nuevonombrerazon = "";
                    $this->nuevonombrecomercial = "";
                    $this->nuevodireccion = '';
                    if ($persona['error'] == "RUC invalido") {
                        session()->flash('success', 'RUC invalido');
                        $this->mensaje = '';
                    }
                    if ($persona['error'] == "RUC debe contener 11 digitos") {
                        session()->flash('success', 'RUC debe contener 11 digitos');
                        $this->mensaje = '';
                    }
                } else {
                    $this->mensaje ="";

                    $this->nuevonombrerazon = $persona['nombre'];
                    $this->nuevonombrecomercial = $persona['nombre'];
                    $this->nuevodireccion = $persona['direccion'];
                }
            } catch (RequestException $e) {
                if ($e->getCode() === CURLE_OPERATION_TIMEOUTED) {
                    session()->flash('success', 'Se ha superado el límite de tiempo de la solicitud. Por favor, inténtalo de nuevo más tarde.');
                    $this->mensaje = '';
                } else {
                    session()->flash('success', 'Ocurrió un error al consumir la API:');
                    $this->mensaje = '';
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.venta-create');
    }

    public function updatedproductoId($value)
    {
        $producto=Producto::find($value);
        // Verifica que el índice esté dentro del rango válido.
        // $this->isEdit = null;
        // if ($producto) {
        //     $this->cantidad = 1;
        //     $this->precio = $producto->precio;
        //     $this->eje = 0;
        //     $this->emit('modalproducto');
        // }

        $this->validate([
            'cantidad_final'             => 'required',
        ]);
        $precio = $this->cantidad_final > 2 ? $producto->precio_doc : $producto->precio;
        if($producto){
            $detalle = [
                'cantidad' => $this->cantidad_final,
                'productoId' => $this->productoId,
                'productonombre' => $producto->nombre.'-'.$producto->codigo,
                'precio' => $precio,
                'subtotal' => $precio*$this->cantidad_final,
            ];
            if($this->isEdit != '' ){
                $this->detalleProductos[$this->isEdit] = $detalle;
            }else{
                $this->detalleProductos[] = $detalle;
            }
            $this->contDetalles++;
            $this->precioProducto[$this->contDetalles] = $precio;
            $this->cantidadProducto[$this->contDetalles] = $this->cantidad_final;
            $this->productoId = '';
            $this->cantidad_final = 1;
            $this->calcularTotal();
            $this->emit('cerrarModalproducto');
        }
    }

    public function updatedprecioProducto($nested,$value)
    {
        if($this->precioProducto[$value]<0)
        {
            $this->precioProducto[$value] = 0;
            $this->detalleProductos[$value]['subtotal'] = 0;
        }
        else{
            $this->detalleProductos[$value]['subtotal'] = $this->cantidadProducto[$value] * $this->precioProducto[$value];
            $this->calcularTotal();
        }
        
    }

    public function updatedcantidadProducto($nested,$value)
    {
        if($this->cantidadProducto[$value]<0)
        {
            $this->cantidadProducto[$value] = 0;
            $this->detalleProductos[$value]['subtotal'] = 0;
        }
        else{        
            $this->detalleProductos[$value]['subtotal'] = $this->cantidadProducto[$value] * $this->precioProducto[$value];
            $this->calcularTotal();
        }
    }

    public function agregar()
    {
        $this->validate([
            'cantidad'             => 'required',
            'precio'        => 'required',
            'eje'        => 'required',
        ]);

        $producto=Producto::find($this->productoId);

        if($producto){
            $detalle = [
                'cantidad' => $this->cantidad,
                'productoId' => $this->productoId,
                'productonombre' => $producto->nombre.'-'.$producto->categoria->nombre.'-'.$producto->categoria->abreviatura.'-'.$producto->serie->nombre,
                'precio' => $this->precio,
                'subtotal' => $this->precio*$this->cantidad,
                'eje' => $this->eje,
            ];
            if($this->isEdit != '' ){
                $this->detalleProductos[$this->isEdit] = $detalle;
            }else{
                $this->detalleProductos[] = $detalle;
            }
            $this->productoId = '';
            $this->cantidad = 1;
            $this->precio = $producto->precio;
            $this->eje = 0;
            $this->calcularTotal();
            $this->emit('cerrarModalproducto');
        }
    }

    public function cancelarProducto(){
        $this->productoId = '';
        $this->cantidad = 1;
        $this->precio = 0;
        $this->eje = 0;
        $this->emit('cerrarModalproducto');
    }

    public function editarProducto($index)
    {
        $this->isEdit = $index;
        $this->productoId = $this->detalleProductos[$index]['productoId'];
        $this->cantidad = $this->detalleProductos[$index]['cantidad'];
        $this->precio = $this->detalleProductos[$index]['precio'];
        $this->eje = $this->detalleProductos[$index]['eje'];
        $this->emit('modalproducto');
    }

    public function eliminarProducto($index)
    {
        unset($this->detalleProductos[$index]);
        unset($this->precioProducto[$index]);
        unset($this->cantidadProducto[$index]);
        $this->cantidadProducto = array_values($this->cantidadProducto);
        $this->precioProducto = array_values($this->precioProducto);
        $this->detalleProductos = array_values($this->detalleProductos);
        $this->calcularTotal();
        $this->contDetalles--;
    }

    public function validarventa()
    {
        $this->validate([
            'clienteId'             => 'required|exists:clientes,id',
            'tipo_documento'        => 'required',
        ]);
    }

    public function modalCobrar()
    {
        $this->validarventa();
        $this->totalpago = $this->total;
        $this->emit('modalCobrar');
    }

    public function modalCobrarCerrar()
    {
        $this->totalpago = 0;
        $this->medioId = 1;
        $this->emit('modalCobrarCerrar');
    }

    public function cobrar()
    {
        $this->validate([
            'medioId'             => 'required|exists:medios,id',
            'totalpago'        => 'required|numeric|max:'.$this->total,
        ]);
        $this->registrarVenta(1);
    }

    public function registrarVenta($valor)
    {
        $this->validarventa();

        try
        {
            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            if($this->tipo_documento != null){
                $documento = Documento::find($this->tipo_documento);
                if(!$this->idVentaEdit){
                    $documento->cantidad = $documento->incremento + $documento->cantidad;
                    $documento->save();
                    $venta = new Venta();
                    $venta->nume_doc = $documento->cantidad;
                    $venta->fecha = $mytime->toDateTimeString();
                }
                
                
                $venta->sucursal_id = \Auth::user()->sucursal->id;
                $venta->almacen_id = \Auth::user()->sucursal->almacen->id;
                $venta->user_id = \Auth::user()->id;
                $venta->cliente_id = $this->clienteId;
                $venta->documento_id = $this->tipo_documento;
                $venta->pago = 1;

                if($valor == 1){
                    $monto=0;
                    if($this->totalpago > 0){
                        $monto=$this->totalpago;
                    }else{
                        $monto = $this->total;
                    }
                    $saldo = $this->total - $monto;
                    $venta->acuenta = $monto;
                    $venta->saldo = $saldo;
                    $venta->total = $this->total;
                    $venta->tipo = $this->tipoventa;
                    $venta->estadoPagado = $saldo == 0 ? '1':'0';
                }
                else{
                    $venta->acuenta = 0;
                    $venta->saldo = $this->total;
                    $venta->total = $this->total;
                    $venta->tipo = $this->tipoventa;
                    $venta->estadoPagado = 1;
                }
                $venta->save();
                $pago=Pago::create([
                    'user_id' => \Auth::user()->id,
                    'medio_id' => $this->medioId,
                    'venta_id' => $venta->id,
                    'caja_id' => $caja->id,
                    'tipo' => 1,
                    'fecha' => $mytime->toDateTimeString(),
                    'total' => $this->total,
                ]);

                foreach($this->detalleProductos as $i => $detalle)
                {
                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $detalle['productoId'],
                        'cantidad' => $this->cantidadProducto[$i],
                        'precio' => $this->precioProducto[$i],
                    ]);

                    $producto = Producto::find($detalle['productoId']);
                    $producto->stock = $producto->stock - $detalle['cantidad'];
                    $producto->save();

                    $stock= Stock::where('almacen_id',\Auth::user()->sucursal->almacen->id)->where('producto_id',$detalle['productoId'])->first();
                    if($stock){
                        $stock->cantidad = $stock->cantidad - $detalle['cantidad'];
                        $stock->save();
                    }else{
                        $stock = new Stock();
                        $stock->almacen_id = \Auth::user()->sucursal->almacen->id;
                        $stock->producto_id = $detalle['productoId'];
                        $stock->cantidad = 0 - $detalle['cantidad'];
                        $stock->save();
                    }

                    if($documento->nombre == 'BOLETA DE VENTA ELECTRÓNICA' || $documento->nombre == 'FACTURA ELECTRÓNICA'){

                        $company = ModelsCompany::find(1); 
                        $totales = collect([
                            'MtoOperGravadas' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18,
                            'MtoIGV' => ($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18,
                            'TotalImpuestos' => ($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18,
                            'ValorVenta' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18,
                            'SubTotal' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18 + (($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18),
                            'MtoImpVenta' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18 + (($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18),
                        ]);
    
                        $sunat = new SunatService();
                        $see = $sunat->getSee($company);
                        $invoice = $sunat->getInvoice($company,$documento,$venta,$totales);
    
                        $result = $see->send($invoice);
    
                        $response['xml'] = $see->getFactory()->getLastXml();
                        $response['hash'] = (new XmlUtils())->getHashSign($response['xml']);
                        $response['sunatResponse'] = $sunat->sunatResponse($result);
                        $documentoSunat = DocumentoSunat::create([
                            'xml' => $response['xml'],
                            'hash' => $response['hash'],
                            'respuesta' => $response['sunatResponse']['success'],
                            'codeError' => $response['sunatResponse']['error']['code'] ?? null,
                            'messageError' => $response['sunatResponse']['error']['message'] ?? null,
                            'cdrZip' => $response['sunatResponse']['cdrZip'] ?? null,
                            'codeCdr' => $response['sunatResponse']['cdrResponse']['code'] ?? null,
                            'descripcionCdr' => $response['sunatResponse']['cdrResponse']['descripcion'] ?? null,
                            'notesCdr' => isset($response['sunatResponse']['cdrResponse']['notes']) 
                                            ? json_encode($response['sunatResponse']['cdrResponse']['notes'])
                                            : null,
                            'venta_id' => $venta->id,
                        ]);
    
                        if($response['sunatResponse']['success'] && $response['sunatResponse']['cdrResponse']['code'] == 0){
                            $venta->sunat = 1;
                            $venta->save();
                            session()->flash('warning', 'Comprobante Electronico aprobado');
                        }else{
                            $venta->sunat = 0;
                            $venta->save();
                            session()->flash('dark', 'Comprobante Electronico rechazado');
                        }
                    }
                }
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        $this->emit('abrirVenta', $venta->id);

        
        return redirect()->route('venta.create')
            ->with('success', 'Venta Agregado Correctamente.');
    }

    public function calcularTotal()
    {
        $totalcantidad = 0;
        $total=0;
        foreach($this->detalleProductos as $i => $detalle)
        {
            $total += $detalle['subtotal'];
            $totalcantidad += $detalle['cantidad'];
        }
        $this->total = $total;
        $this->cantidadproductos = $totalcantidad;
    }

    public function abrirmodalcliente()
    {
        $this->emit('abrirmodalcliente');
    }

}
