<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DatabaseContactsExport implements FromQuery, WithMapping,WithStyles, WithHeadings,ShouldQueue
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $sr_no = 1;
    public function query()
    {
        return Contact::query()->with(['emailIds:email,id,contact_id','phoneNumbers:phone,id,contact_id']);
    }
    public function map($contact): array
    {
        return [
            $this->sr_no++,
            $contact->first_name,
            $contact->last_name,
            $contact->birthdate,
            $contact->address,
            implode(",\n",$contact->emailIds->pluck('email')->toArray()),
            implode(",\n",$contact->phoneNumbers->pluck('phone')->toArray()),
        ];
    }
    public function styles(Worksheet $sheet)
    {

        $sheet->getDefaultRowDimension()->setRowHeight(70);
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:G')->getAlignment()->setVertical('center');

        // Wrap Text
        $sheet->getStyle('H')->getAlignment()->setWrapText(true);
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
        $sheet->getStyle('G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('E')->getAlignment()->setWrapText(true);

        // Column Dimesions
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(36);
        $sheet->getColumnDimension('F')->setWidth(36);
        $sheet->getColumnDimension('G')->setWidth(36);
    }
    public function headings(): array
    {
        return [
            'Sr. No',
            'First Name',
            'Last Name',
            'Birthdate',
            'Address',
            'Email',
            'Phone',
        ];
    }

}
