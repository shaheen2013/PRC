<?php

namespace App\Nova\Actions;

use Carbon\Carbon;
use App\Models\Contract;
use App\Models\CMCommunity;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportContracts extends DownloadExcel implements ShouldAutoSize, WithMapping, WithEvents
{
    public function map($contract): array
    {
        try {
            $date = new Carbon($contract->expiration_date);
        } catch (\Exception $e) {
        }

        return [
            $contract->community->FRIENDLYNAME,
            $contract->rental,
            $contract->vacant,
            $contract->foreclosure,
            date_format($contract->start_date, 'Y-m-d'),
            date_format($contract->expiration_date, 'Y-m-d'),
            $date->diffForHumans(null, false, false, 2),
            $contract->number_of_terms === 0 ? 'Limitless' : $contract->number_of_terms,
            $contract->term_length,
            (new Contract())->getLabel($contract->auto_renewal),
            $contract->assignment,
            $contract->consent_required,
            $contract->notice_required,
            strip_tags($contract->description),
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
}
