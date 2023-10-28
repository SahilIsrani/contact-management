<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContactExport implements FromCollection, WithHeadings, WithStyles
{
    protected $failures;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Collection $failures = null)
    {
        $this->failures = $failures;
    }
    public function collection()
    {
        // dd($this->failures);
        $collection = new Collection();
        $previousRow = null;
        $failedRow = [];
        foreach($this->failures as $idx => $failure){
            $attribute = $failure->attribute();
            $values = $failure->values();
            $errors = $failure->errors();

            if($previousRow !== $failure->row())
            {
                if($previousRow !== null)
                {
                    $collection->push($failedRow);
                }
                $failedRow = $values;
                $failedRow['email'] = implode(",\n",$failedRow['email']);
                $failedRow['phone'] = implode(",\n",$failedRow['phone']);
                $failedRow['errors'] = '';
            }
            $attr = explode('.',$attribute);

            if($attr !== [] )
            {
                if($attr[0] === 'email') {
                    $index = intval($attr[1]);
                    if($values['email'][0]==="") {
                        $errors[0] = str_replace($attribute,"Email",$errors[0]);
                    } else {
                        $errors[0] = str_replace($attribute,"email "."\"".$values['email'][$index]."\"",$errors[0]);
                    }
                }
                elseif($attr[0] === 'phone') {
                    $index = intval($attr[1]);
                    if($values['phone'][0]===""){
                        $errors[0] = str_replace($attribute,"Phone",$errors[0]);
                    } else {
                        $errors[0] = str_replace($attribute,"phone no. "."\"".$values['phone'][$index]."\"",$errors[0]);
                    }
                } else {
                    $temp = Str::title($attribute);
                    $temp = str_replace('_',' ',$temp);

                    $errors[0] = str_replace($attribute,$temp,$errors[0]);
                }
            }
            $failedRow['errors'] = $failedRow['errors'].$errors[0]."\n";
            $previousRow = $failure->row();
            if($idx === $this->failures->count()-1) {
                $collection->push($failedRow);
            }
        }
        return $collection;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('H')->getAlignment()->setWrapText(true);
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
        $sheet->getStyle('G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A:H')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:H1')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center')->setVertical('center');


        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(36);
        $sheet->getColumnDimension('F')->setWidth(36);
        $sheet->getColumnDimension('G')->setWidth(36);
        $sheet->getColumnDimension('H')->setWidth(65);

        $sheet->getStyle('H')->getFont()->getColor()->setARGB('FFFF0000');
        $sheet->getStyle('H1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('H1')->getFill()->getStartColor()->setARGB('FFFF0000');
        $sheet->getStyle('H1')->getFont()->getColor()->setARGB('00000000');
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
            'Errors'
        ];
    }

}
