<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class VentasProductosExport implements FromView, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct(public $ventas,public $fechaFin2, public $fechaInicio2, public $searchCliente2)
    {
    }


    public function styles(Worksheet $sheet)
    {
        $lastRow        = $sheet->getHighestDataRow();
        $lastColumn     = $sheet->getHighestColumn();
        $headerColor    = '62C8D5';
        $numDataColor   = '99FF33';
        $borderColor    = '000000';

        // Estilo de encabezado
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => $headerColor
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        // Estilo de datos numéricos
        $numDataStyle = [
            'font' => [
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => $numDataColor,
                ],
            ],
        ];
        // Estilo de cuadrícula
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => $borderColor],
                ],
            ],
        ];

        // Aplicar estilo a los encabezados
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($headerStyle);
        // Negrita 
    }

    public function view(): View
    {
        $ventas = $this->ventas;
        $fechaFin2 = $this->fechaFin2;
        $fechaInicio2 = $this->fechaInicio2;
        $searchCliente2 = $this->searchCliente2;
        return view('pages.excel.ventas-productos-excel', compact('ventas','fechaFin2','fechaInicio2','searchCliente2'));
    }
}
