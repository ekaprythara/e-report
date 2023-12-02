<?php

namespace App\Exports;

use App\Models\OutboundLogistic;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class OutboundLogisticExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithCustomStartCell
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
        return OutboundLogistic::with('inboundLogistic', 'receiver')
            ->where('hasExpired', '=', '0')
            ->where('outboundDate', '>=', $this->from)
            ->where('outboundDate', '<=', $this->to)
            ->orderBy('outboundDate')
            ->oldest()
            ->get();
    }

    protected $i = 1;

    public function map($outboundLogistic): array
    {
        if (isset($outboundLogistic->receiver->receiverUnit->name)) {
            $receiver = $outboundLogistic->receiver->name;
        }

        return [
            $this->i++,
            $outboundLogistic->outboundDate,
            $outboundLogistic->inboundLogistic->logistic->name,
            $outboundLogistic->inboundLogistic->supplier->name ?? $outboundLogistic->inboundLogistic->supplier,
            $outboundLogistic->receiver->receiverUnit->name ?? '',
            $receiver ?? '',
            $outboundLogistic->quantity,
            $outboundLogistic->inboundLogistic->logistic->standardUnit->name,
            $outboundLogistic->description
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Keluar',
            'Logistik',
            'Penyuplai',
            'Unit Penerima',
            'Penerima',
            'Jumlah',
            'Satuan',
            'Keterangan'
        ];
    }

    public function registerEvents(): array
    {
        $outboundLogistic = OutboundLogistic::with('inboundLogistic', 'receiver')
            ->where('hasExpired', '=', '0')
            ->where('outboundDate', '>=', $this->from)
            ->where('outboundDate', '<=', $this->to)
            ->orderBy('outboundDate')
            ->oldest()
            ->get();
        $temp_count = $outboundLogistic->count();
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
                $event->sheet->getDelegate()->mergeCells('A4:I4')->setCellValue('A4', 'LAPORAN LOGISTIK KELUAR')
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
    //     return view('/ekspor/logistik-keluar/excel', [
    //         "title" => "Logistik Keluar",
    //         "from" => $this->from,
    //         "to" => $this->to,
    //         "outboundLogistics" => OutboundLogistic::where('outboundDate', '>=', $this->from)
    //             ->where('outboundDate', '<=', $this->to)
    //             ->orderBy('outboundDate')
    //             ->oldest()
    //             ->get(),
    //     ]);
    // }
}
