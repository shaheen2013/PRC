<?php

namespace App\Nova\Actions;

use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportContacts extends DownloadExcel implements ShouldAutoSize, WithMapping, WithEvents
{
    public function map($contact): array
    {
        return [
            $contact->ID,
            $contact->FIRSTNAME,
            $contact->OTHERNAMES,
            $contact->typeLabel,
            $contact->EMAIL,
            $contact->PHONE,
            Carbon::parse($contact->lastLogin)->toDateTimeString(),
            Carbon::parse($contact->lastInteractionDate)->toDateTimeString(),
        ];
    }

    //Adds links to the ID column to take user to Contact Detail page
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->setAutoFilter('A1:I1');
                foreach ($event->sheet->getColumnIterator('A') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if ($cell->getColumn() == 'A' && $cell->getValue() !== 'Id') {
                            $cell->setHyperlink(new Hyperlink(url("/admin/resources/c-m-contacts/{$cell->getValue()}"), 'Read'));
                            // Upd: Link styling added
                            $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                                'font' => [
                                    'color' => ['rgb' => '0000FF'],
                                    'underline' => 'single',
                                ],
                            ]);
                        }
                    }
                }
            },
        ];
    }
}
