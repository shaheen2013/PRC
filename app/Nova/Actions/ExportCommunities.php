<?php

namespace App\Nova\Actions;

use App\Models\CMCommunity;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportCommunities extends DownloadExcel implements WithColumnFormatting, ShouldAutoSize, WithMapping, WithEvents
{
    public function map($community): array
    {
        return [
            $community->COMMUNITYID,
            $community->FRIENDLYNAME,
            $community->STATE,
            $community->COUNTY,
            data_get($community->relationshipManagers->get('0'), 'name', ''),
            data_get($community->relationshipManagers->get('1'), 'name', null),
            $community->housingData ? $this->calculateCommunitySize($community->housingData->quartile) : 'X-Small',
            $community->housingData ? floatval($community->housingData->housing_units) : 'Not Available',
            number_format($this->calculateSalesStatus($community->rentalVacantSalesStatus ? $community->rentalVacantSalesStatus->rental_status : 1)),
            $community->housingData ? floatval($community->housingData->est_long_term_rental) : 'Not Available',
            number_format($this->calculateSalesStatus($community->rentalVacantSalesStatus ? $community->rentalVacantSalesStatus->vacant_status : 1)),
            $community->housingData ? floatval($community->housingData->est_vacant_total) : 'Not Available',
            number_format($this->calculateSalesStatus($community->crmForeclosureSale ? $community->crmForeclosureSale->SALESSTATUSID : 1)),
            $community->foreclosureStats->where('ISMOSTCURRENT', 1)->first() ?
                $community->foreclosureStats->where('ISMOSTCURRENT', 1)->first()->FORECLOSURESACTIVE : 'Not Available',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->setAutoFilter('A1:N1');
            },
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::builtInFormatCode(3),
            'I' => NumberFormat::builtInFormatCode(3),
            'K' => NumberFormat::builtInFormatCode(3),
            'M' => NumberFormat::builtInFormatCode(3),
        ];
    }

    public function calculateCommunitySize($quartile)
    {
        switch ($quartile) {
            case 0:
                return 'X-Small';
            case 1:
                return 'Small';
            case 2:
                return 'Medium';
            case 3:
                return 'Large';
            case 4:
                return 'X-Large';
            default:
                return '';
        }
    }

    public function calculateSalesStatus($statusId)
    {
        switch ($statusId) {
            case 1:
                return 0;
            case 5:
                return 5;
            case 6:
                return 4;
            case 7:
                return 1;
            case 10:
                return 0;
            case 11:
                return 2;
            case 12:
                return 3;
            case 13:
                return 1;
            case 14:
                return 6;
            default:
                return 0;
        }
    }
}
