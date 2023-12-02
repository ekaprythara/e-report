<?php

namespace App\Exports;

use App\Models\Logistic;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class LogisticStockExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithCustomStartCell
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return Logistic::all()
            ->sortBy('name');
    }

    protected $logisticStock;
    protected $i = 1;


    public function map($logistic): array
    {
        if ($logistic->stock > 0) {
            $logisticStock = $logistic->stock;
        } else {
            $logisticStock = '0';
        }

        return [
            $this->i++,
            $logistic->name,
            $logistic->logisticType->name,
            $logisticStock,
            $logistic->standardUnit->name,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Logistik',
            'Jenis Logistik',
            'Stok',
            'Satuan'
        ];
    }

    public function registerEvents(): array
    {
        $logistic = Logistic::all()
            ->sortBy('name');
        $temp_count = $logistic->count();
        $count = $temp_count + 6;
        $cellRange = "A6:E" . $count;
        // dd($cellRange);
        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:E1')->setCellValue('A1', 'PEMERINTAH PROVINSI BALI')
                    ->getStyle('A1:E1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->mergeCells('A2:E2')->setCellValue('A2', 'BADAN PENANGGULANGAN BENCANA DAERAH')
                    ->getStyle('A2:E2')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->mergeCells('A4:E4')->setCellValue('A4', 'LAPORAN STOK LOGISTIK')
                    ->getStyle('A4:E4')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A6:E6')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);
            }
        ];
    }

    public function startCell(): string
    {
        return 'A6';
    }

    // public function view(): View
    // {
    //     return view('/ekspor/stok-logistik/excel', [
    //         "title" => "Logistik",
    //         "logistics" => Logistic::with(['logistics', 'standardUnit'])
    //             ->sortBy('name')
    //             ->get(),
    //         "logisticTypes" => LogisticType::all(),
    //         "standardUnits" => StandardUnit::all()
    //     ]);
    // }
}
