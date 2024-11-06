<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use Illuminate\Support\Facades\Http;

class CrearCliente extends Component
{
    public $nuevotipo_documento;
    public $nuevodocumento;
    public $nuevonombrecomercial;
    public $nuevonombrerazon;
    public $nuevotelefono;
    public $nuevodireccion;
    public $nuevocorreo;
    public $nuevozona;
    public $nuevotipocliente="PROVINCIA";

    public $clientes;
    public $mensaje;
    public $text;
    public $botontext;
    public $cliente;

    public function mount($cliente = null)
    {
        $this->cliente = $cliente;
        $this->botontext = "Guardar";

        if($cliente != null){
            $this->botontext = "Editar";
            
            $this->nuevotipo_documento = $this->cliente->documento;
            $this->nuevodocumento = $this->cliente->num_documento;
            $this->nuevonombrecomercial = $this->cliente->nombre_comercial;
            $this->nuevonombrerazon = $this->cliente->razon_social;
            $this->nuevotelefono = $this->cliente->telefono;
            $this->nuevodireccion = $this->cliente->direccion;
            $this->nuevocorreo = $this->cliente->correo;
            $this->nuevozona = $this->cliente->zona;
            $this->nuevotipocliente = $this->cliente->tipo;
        }
    }

    public function agregarCliente()
    {
        if($this->cliente != null){
            $cliente = Cliente::find($this->cliente->id);
        }else{
            $cliente = new Cliente();
        }

        $this->validate([
            'nuevotipo_documento' => 'required',
            'nuevodocumento' => 'required|max:15',
            'nuevonombrerazon' => 'required|max:250',
            'nuevonombrecomercial' => 'required|max:250',
            'nuevodireccion' => 'nullable|max:255',
            'nuevotelefono' => 'nullable|max:50',
            'nuevocorreo' => 'nullable|email|max:250',
        ]);

        $cliente->documento = $this->nuevotipo_documento;
        $cliente->num_documento = $this->nuevodocumento;
        $cliente->razon_social = $this->nuevonombrerazon;
        $cliente->nombre_comercial = $this->nuevonombrecomercial;
        $cliente->telefono = $this->nuevotelefono;
        $cliente->direccion = $this->nuevodireccion;
        $cliente->correo = $this->nuevocorreo;
        $cliente->tipo = $this->nuevotipocliente;
        $cliente->zona = $this->nuevozona;
        $cliente->sunat = $this->nuevotipo_documento == 'DNI' ? '1':'6';
        $cliente->save();


        return redirect()->route('cliente.index')
            ->with('success', 'Cliente Agregado Correctamente.');
    }

    public function searchDocumento()
    {
        if ($this->nuevotipo_documento == 'DNI') {
            $cliente = Cliente::where('num_documento', $this->nuevodocumento)->first();
            if ($cliente) {
                $this->nuevonombrerazon = $cliente->razon_social;
                $this->nuevonombrecomercial = $cliente->nombre_comercial;
                $this->nuevotelefono = $cliente->telefono;
                $this->nuevodireccion = $cliente->direccion;
                $this->nuevocorreo = $cliente->correo;
                $this->nuevotipocliente = $cliente->tipo;
                $this->mensaje = '';
            } else {
                $this->searchDNIInAPI($this->nuevodocumento);
                $this->mensaje = $cliente?->razon_social ? '' : 'Este cliente no está registrado en nuestra base de datos DNI';
            }
        } elseif ($this->nuevotipo_documento == 'RUC') {
            $cliente = Cliente::where('num_documento', $this->nuevodocumento)->first();
            if ($cliente) {
                $this->nuevonombrerazon = $cliente->razon_social;
                $this->nuevonombrecomercial = $cliente->nombre_comercial;
                $this->nuevotelefono = $cliente->telefono;
                $this->nuevodireccion = $cliente->direccion;
                $this->nuevocorreo = $cliente->correo;
                $this->nuevotipocliente = $cliente->tipo;
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
        return view('livewire.crear-cliente');
    }
}
