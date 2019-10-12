<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportBrandingConfiguration extends DownloadExcel implements WithColumnFormatting, ShouldAutoSize, WithMapping, WithEvents
{
    public function map($community): array
    {
        $community->load('brandingConfiguration');

        return [
            $community->COMMUNITYID,
            $community->FRIENDLYNAME,
            $community->COUNTY,
//            $community->STATE,
            $community->logo ? 'True' : 'False',
            $community->brandingConfiguration ? ($community->brandingConfiguration->redirect_url ? 'True' : 'False') : 'False',
            $community->brandingConfiguration ? ($community->brandingConfiguration->redirect_email ? 'True' : 'False') : 'False',
            $community->brandingConfiguration ? ($community->brandingConfiguration->redirect_phone ? 'True' : 'False') : 'False',
            $community->brandingConfiguration ? ($community->brandingConfiguration->landing_page_content ? 'True' : 'False') : 'False',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->setAutoFilter('A1:I1');
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
