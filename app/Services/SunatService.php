<?php

namespace App\Services;

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Luecano\NumeroALetras\NumeroALetras;

class SunatService
{
    public function getSee($company)
    {
        $see = new See();
        $certificado = base_path('certificado_cert_out.pem');
        $see->setCertificate(file_get_contents($certificado));
        $see->setService($company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA);
        $see->setClaveSOL($company->ruc, $company->sol_user, $company->sol_pass);

        return $see;
    }

    public function getInvoice($company,$documento,$venta,$totales)
    {
        if($venta->pago == 0){
            return (new Invoice())
                ->setUblVersion('2.1')
                ->setTipoOperacion('0101') // Venta - Catalog. 51
                ->setTipoDoc($documento->codSunat) // Factura - Catalog. 01 
                ->setSerie($documento->serie)
                ->setCorrelativo($documento->cantidad)
                ->setFechaEmision(new DateTime($venta->fecha)) // Zona horaria: Lima
                ->setFormaPago(new FormaPagoCredito($totales['MtoImpVenta']))
                ->setCuotas([
                    (new Cuota())
                        ->setMonto($totales['MtoImpVenta'])
                        ->setFechaPago(new DateTime('+7days')),
                ]) // FormaPago: Contado
                ->setTipoMoneda('PEN') // Sol - Catalog. 02
                ->setCompany($this->getCompany($company))
                ->setClient($this->getClient($venta->cliente))
                ->setMtoOperGravadas($totales['MtoOperGravadas'])
                ->setMtoIGV($totales['MtoIGV'])
                ->setTotalImpuestos($totales['TotalImpuestos'])
                ->setValorVenta($totales['ValorVenta'])
                ->setSubTotal($totales['SubTotal'])
                ->setMtoImpVenta($totales['MtoImpVenta'])
                ->setDetails($this->getDetails($venta->detallesVenta))
                ->setLegends([$this->getLegends($totales)]);
        }
        return (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51
            ->setTipoDoc($documento->codSunat) // Factura - Catalog. 01 
            ->setSerie($documento->serie)
            ->setCorrelativo($documento->cantidad)
            ->setFechaEmision(new DateTime($venta->fecha)) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            ->setTipoMoneda('PEN') // Sol - Catalog. 02
            ->setCompany($this->getCompany($company))
            ->setClient($this->getClient($venta->cliente))
            ->setMtoOperGravadas($totales['MtoOperGravadas'])
            ->setMtoIGV($totales['MtoIGV'])
            ->setTotalImpuestos($totales['TotalImpuestos'])
            ->setValorVenta($totales['ValorVenta'])
            ->setSubTotal($totales['SubTotal'])
            ->setMtoImpVenta($totales['MtoImpVenta'])
            ->setDetails($this->getDetails($venta->detallesVenta))
            ->setLegends([$this->getLegends($totales)]);
    }

    public function getNote($company,$documento,$venta,$totales,$note)
    {
        return (new Note())
            ->setUblVersion('2.1')
            ->setTipoDoc($documento->codSunat) // Factura - Catalog. 01 
            ->setSerie($documento->serie)
            ->setCorrelativo($documento->cantidad)
            ->setFechaEmision(new DateTime($note->fecha)) // Zona horaria: Lima
            ->setTipDocAfectado($venta->documento->codSunat)
            ->setNumDocfectado($venta->documento->serie.'-'.$venta->nume_doc)
            ->setCodMotivo($note->cod_note)
            ->setDesMotivo($note->descripcion)
            ->setTipoMoneda('PEN') // Sol - Catalog. 02
            ->setCompany($this->getCompany($company))
            ->setClient($this->getClient($venta->cliente))
            ->setMtoOperGravadas($totales['MtoOperGravadas'])
            ->setMtoIGV($totales['MtoIGV'])
            ->setTotalImpuestos($totales['TotalImpuestos'])
            ->setValorVenta($totales['ValorVenta'])
            ->setSubTotal($totales['SubTotal'])
            ->setMtoImpVenta($totales['MtoImpVenta'])
            ->setDetails($this->getDetails($venta->detallesVenta))
            ->setLegends([$this->getLegends($totales)]);
    }

    public function getCompany($company)
    {
        return (new Company())
            ->setRuc($company->ruc)
            ->setRazonSocial($company->razon_social)
            ->setNombreComercial($company->razon_social)
            ->setAddress($this->getAddress($company));
    }

    public function getClient($cliente)
    {
        return (new Client())
        ->setTipoDoc($cliente->sunat)
        ->setNumDoc($cliente->num_documento)
        ->setRznSocial($cliente->razon_social);
    }

    public function getAddress($company)
    {
        return (new Address())
            ->setUbigueo($company->ubigeo)
            ->setDepartamento($company->departamento)
            ->setProvincia($company->provincia)
            ->setDistrito($company->distrito)
            ->setUrbanizacion('-')
            ->setDireccion($company->direccion)
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
    }

    public function getDetails($detalles)
    {
        $details=[];
        
        foreach($detalles as $detalle)
        {
            $details[] = (new SaleDetail())
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setCodProducto($detalle->producto_id)
            ->setUnidad('NIU') // Unidad - Catalog. 03
            ->setCantidad($detalle->cantidad)
            ->setMtoValorUnitario(number_format($detalle->precio/1.18,2, '.', ''))
            ->setDescripcion($detalle->producto->nombre)
            ->setMtoBaseIgv(number_format(($detalle->precio/1.18)*$detalle->cantidad,2, '.', ''))
            ->setPorcentajeIgv(18.00) // 18%
            ->setIgv(number_format((($detalle->precio/1.18)*$detalle->cantidad)*0.18,2, '.', ''))
            ->setTotalImpuestos(number_format((($detalle->precio/1.18)*$detalle->cantidad)*0.18,2, '.', '')) // Suma de impuestos en el detalle
            ->setMtoValorVenta(number_format(($detalle->precio/1.18)*$detalle->cantidad,2, '.', ''))
            ->setMtoPrecioUnitario(number_format(($detalle->precio/1.18)+(($detalle->precio/1.18)*0.18),2, '.', ''));
        }
        return $details;            
    }

    public function getLegends($totales)
    {
        $formatear = new NumeroALetras();

        return (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52
            ->setValue($formatear->toInvoice($totales['MtoImpVenta'],2,'SOLES'));
    }

    public function sunatResponse($result)
    {
        $response['success'] = $result->isSuccess();
        if (!$result->isSuccess()) {
            // Mostrar error al conectarse a SUNAT.
            $response['error'] = [
                'code' => $result->getError()->getCode(),
                'message' => $result->getError()->getMessage()
            ];

            return $response; 
        }
        
        $cdr = $result->getCdrResponse();

        $response['cdrZip'] = base64_encode($result->getCdrZip());

        $response['cdrResponse'] = [
            'code' => (int)$cdr->getCode(),
            'descripcion' => $cdr->getDescription(),
            'notes' => $cdr->getNotes(),
        ];

        return $response; 
    }
}