<?php

namespace App\Exports;

use App\Models\Movimiento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MovimientosExport implements FromView, ShouldAutoSize, WithStyles
{
    public function __construct(public $movimiento)
    {
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow        = $sheet->getHighestDataRow();
        $lastColumn     = $sheet->getHighestColumn();
        $headerColor    = 'FFFF00';
        $numDataColor   = '99FF33';
        $borderColor    = '000000';
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000']
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
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => $borderColor],
                ],
            ],
        ];
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($headerStyle);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(12)->setBold(true)->applyFromArray($headerStyle);
    }

    public function view(): View
    {
        $movimiento = $this->movimiento;
        return view('pages.excel.exportMovimiento', compact('movimiento'));
    }
}
