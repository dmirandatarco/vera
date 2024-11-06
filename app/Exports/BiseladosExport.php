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

class BiseladosExport implements FromView, ShouldAutoSize, WithStyles, WithDrawings
{
    use Exportable;

    public function __construct(public $trabajos,public $fechaFin2, public $fechaInicio2,public $maquina2,public $trabajador2)
    {
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Zolux Cusco');
        $drawing->setPath(public_path('storage/logo.png'));
        $drawing->setHeight(25);
        $drawing->setCoordinates('A1');
        return $drawing;
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
        $sheet->getStyle("A8:{$lastColumn}8")->applyFromArray($headerStyle);
        // Negrita 
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A6')->getFont()->setBold(true);
        $sheet->getStyle('C5')->getFont()->setBold(true);
        $sheet->getStyle('C6')->getFont()->setBold(true);
    }

    public function view(): View
    {
        $trabajos = $this->trabajos;
        $fechaFin2 = $this->fechaFin2;
        $fechaInicio2 = $this->fechaInicio2;
        $maquina2 = $this->maquina2;
        $trabajador2 = $this->trabajador2;
        return view('pages.excel.biselados-excel', compact('trabajos','fechaFin2','fechaInicio2','maquina2','trabajador2'));
    }
}
