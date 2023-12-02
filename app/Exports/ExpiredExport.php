<?php

namespace App\Exports;

use App\Models\InboundLogistic;
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

class ExpiredExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithCustomStartCell
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('expiredDate', '<=', now())
            ->where('stock', '>', '0')
            ->orderBy('expiredDate')
            ->latest()
            ->get();
    }

    protected $i = 1;

    public function map($inboundLogistic): array
    {
        return [
            $this->i++,
            $inboundLogistic->logistic->name,
            $inboundLogistic->supplier->name ?? $inboundLogistic->supplier,
            $inboundLogistic->stock,
            $inboundLogistic->logistic->standardUnit->name,
            $inboundLogistic->expiredDate,
            $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Logistik',
            'Penyuplai',
            'Stok',
            'Satuan',
            'Kedaluwarsa',
            'Jenis Pengadaan',
        ];
    }

    public function registerEvents(): array
    {
        $inboundLogistic = InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('expiredDate', '<=', now())
            ->where('stock', '>', '0')
            ->orderBy('expiredDate')
            ->latest()
            ->get();
        $temp_count = $inboundLogistic->count();
        $count = $temp_count + 6;
        $cellRange = "A6:G" . $count;
        // dd($cellRange);
        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:G1')->setCellValue('A1', 'PEMERINTAH PROVINSI BALI')
                    ->getStyle('A1:G1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->mergeCells('A2:G2')->setCellValue('A2', 'BADAN PENANGGULANGAN BENCANA DAERAH')
                    ->getStyle('A2:G2')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->mergeCells('A4:G4')->setCellValue('A4', 'LAPORAN KEDALUWARSA')
                    ->getStyle('A4:G4')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A6:G6')->applyFromArray([
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
    //     return view('/ekspor/kadaluarsa/excel', [
    //         "title" => "Logistik",
    //         "inboundLogistics" => InboundLogistic::where('expiredDate', '<=', now())
    //             ->where('stock', '>', '0')
    //             ->orderBy('expiredDate')
    //             ->latest()
    //             ->get(),
    //     ]);
    // }
}
