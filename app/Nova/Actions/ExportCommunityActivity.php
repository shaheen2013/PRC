<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportCommunityActivity extends DownloadExcel implements WithColumnFormatting, ShouldAutoSize, WithMapping, WithEvents
{
    public function map($community): array
    {
        return [
            $community->COMMUNITYID,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->setAutoFilter('A1:K1');
            },
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
//            'G' => NumberFormat::builtInFormatCode(3),
//            'I' => NumberFormat::builtInFormatCode(3),
//            'K' => NumberFormat::builtInFormatCode(3),
//            'M' => NumberFormat::builtInFormatCode(3),
        ];
    }
}
