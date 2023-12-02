<?php

namespace App\Exports;

use Carbon\Carbon;
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

class InboundLogisticExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithCustomStartCell
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $from;
    protected $to;

    function __construct($from, $to)
    {
        $this->temp_from = $from;
        $this->from = Carbon::parse($this->temp_from)->locale('id');
        $this->from->settings(['formatFunction' => 'translatedFormat']);

        $this->temp_to = $to;
        $this->to = Carbon::parse($this->temp_to)->locale('id');
        $this->to->settings(['formatFunction' => 'translatedFormat']);
    }

    public function collection()
    {
        return InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('inboundDate', '>=', $this->from)
            ->where('inboundDate', '<=', $this->to)
            ->orderBy('inboundDate')
            ->oldest()
            ->get();
    }

    protected $i = 1;

    public function map($inboundLogistic): array
    {
        return [
            $this->i++,
            $inboundLogistic->inboundDate,
            $inboundLogistic->logistic->name,
            $inboundLogistic->supplier->name ?? $inboundLogistic->supplier,
            $inboundLogistic->amount,
            $inboundLogistic->logistic->standardUnit->name,
            $inboundLogistic->expiredDate,
            $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement,
            $inboundLogistic->description
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Masuk',
            'Logistik',
            'Penyuplai',
            'Jumlah',
            'Satuan',
            'Kedaluwarsa',
            'Jenis Pengadaan',
            'Keterangan'
        ];
    }

    public function registerEvents(): array
    {
        $inboundLogistic = InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('inboundDate', '>=', $this->from)
            ->where('inboundDate', '<=', $this->to)
            ->orderBy('inboundDate')
            ->oldest()
            ->get();
        $temp_count = $inboundLogistic->count();
        $count = $temp_count + 7;
        $cellRange = "A7:I" . $count;
        // dd($cellRange);
        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:I1')->setCellValue('A1', 'PEMERINTAH PROVINSI BALI')
                    ->getStyle('A1:I1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->mergeCells('A2:I2')->setCellValue('A2', 'BADAN PENANGGULANGAN BENCANA DAERAH')
                    ->getStyle('A2:I2')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->mergeCells('A4:I4')->setCellValue('A4', 'LAPORAN LOGISTIK MASUK')
                    ->getStyle('A4:I4')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ]
                    ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                if ($this->from->format('d F Y') == $this->to->format('d F Y')) {
                    $event->sheet->getDelegate()->mergeCells('A5:I5')->setCellValue('A5', $this->from->format('d F Y'))
                        ->getStyle('A5:I5')->applyFromArray([
                            'font' => [
                                'bold' => true,
                            ]
                        ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } else {
                    $event->sheet->getDelegate()->mergeCells('A5:I5')->setCellValue('A5', $this->from->format('d F Y') . ' - ' . $this->to->format('d F Y'))
                        ->getStyle('A5:I5')->applyFromArray([
                            'font' => [
                                'bold' => true,
                            ]
                        ])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                $event->sheet->getStyle('A7:I7')->applyFromArray([
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
        return 'A7';
    }

    // protected $from;
    // protected $to;

    // function __construct($from, $to)
    // {
    //     $this->from = $from;
    //     $this->to = $to;
    // }

    // public function view(): View
    // {
    //     return view('/ekspor/logistik-masuk/excel', [
    //         "title" => "Logistik Masuk",
    //         "inboundLogistics" => InboundLogistic::where('inboundDate', '>=', $this->from)
    //             ->where('inboundDate', '<=', $this->to)
    //             ->orderBy('inboundDate')
    //             ->oldest()
    //             ->get(),
    //     ]);
    // }
}
