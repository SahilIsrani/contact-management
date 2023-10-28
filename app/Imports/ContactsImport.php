<?php

namespace App\Imports;

use App\Models\Contact;


use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Validators\Failure;

class ContactsImport implements OnEachRow,WithValidation ,WithHeadingRow, SkipsEmptyRows,SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function onRow(Row $row)
    {
        // dd($row);
        $contact = Contact::create([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'birthdate' => $row['birthdate'],
            'address' => $row['address'],
            'image' => 'contacts/contact.jpg'
        ]);
        $tempArray = array();
        $primary = 1;
        foreach($row['email'] as $emailId) {
            array_push($tempArray,$contact->emailIds()->make(['email'=>$emailId,'primary'=>$primary]));
            $primary = 0;
        }
        $contact->emailIds()->saveMany($tempArray);
        $tempArray = array();
        $primary = 1;
        foreach($row['phone'] as $phone) {
            array_push($tempArray,$contact->phoneNumbers()->make(['phone'=>$phone,'primary'=>$primary]));
            $primary = 0;
        }
        $contact->phoneNumbers()->saveMany($tempArray);
    }
    public function headingRow() : int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'birthdate' => 'required|date',
            'address' => 'required',
            'email.*' => 'required|email|distinct|unique:email_ids,email',
            'phone.*' => 'required|numeric|min_digits:10|max_digits:10|distinct|unique:phone_numbers,phone',
        ];
    }
    public function prepareForValidation($data, $index)
    {
        $temp = $this->splitValues($data['email']);
        $data['email'] = $temp[0] === "" ? null : $temp;
        $temp =  $this->splitValues($data['phone']);
        $data['phone'] = $temp[0] === "" ? null : $temp;
        return $data;
    }
    public function splitValues($data)
    {
        $csv = trim($data," \n\r\t,");
        $arrayOfValues = explode(',',$csv);
        $arrayOfValues = array_map(array($this,'trimValue'),$arrayOfValues);
        return $arrayOfValues;
    }
    public function trimValue($value) {
        return trim($value,' ');
    }
}
