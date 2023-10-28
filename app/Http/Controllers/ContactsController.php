<?php

namespace App\Http\Controllers;

use App\Exports\ContactExport;
use App\Exports\DatabaseContactsExport;
use App\Imports\ContactsImport;
use App\Models\Contact;
use App\Models\EmailId;
use App\Models\PhoneNumber;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ContactsController extends Controller
{
    public static $importFailures;
    public function upload()
    {
        return view('excel-upload');
    }
    public function import(Request $request) {
        set_time_limit(900);
        $request->validate(['excel' => 'required']);
        $import = new ContactsImport();
        $import->import($request->file('excel'));

        if($import->failures()->isEmpty()) {
            session()->flash('status','success');
            session()->flash('message','Contact added successfully');
            return redirect(route('contacts.index'));
        } else {
            ContactsController::$importFailures = $import->failures();
            Session::put('importFailure',$import->failures());
            session()->flash('status','fail');
            session()->flash('message','Some rows failed');
            return redirect(route('contacts.excel.upload'));
        }
    }
    public function export()
    {
        return Excel::download(new ContactExport(Session::get('importFailure')),'report.xlsx');
    }
    public function download()
    {
        return Excel::download(new DatabaseContactsExport(),'NewContacts.xlsx');
    }
    public function index()
    {
        $contacts = DB::table('contacts')
                    ->join('email_ids',function(JoinClause $join){
                            $join->on('contacts.id','=','email_ids.contact_id');
                        })->where('email_ids.primary','=','1')
                    ->join('phone_numbers',function(JoinClause $join){
                            $join->on('contacts.id','=','phone_numbers.contact_id');
                        })->where('phone_numbers.primary','=','1')->paginate(500);
        return view('index',compact(['contacts']));
    }

    public function create()
    {
        return view('add-contact');
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'email.*' => ['sometimes','required','email','distinct',Rule::unique('email_ids','email')],
            'oldEmail.*' => ['sometimes','required','email','distinct',Rule::unique('email_ids','email')],
            'phone.*' => ['sometimes','required','numeric','min_digits:10','max_digits:10','distinct',Rule::unique('phone_numbers','phone')],
            'oldPhone.*' => ['sometimes','required','numeric','min_digits:10','max_digits:10','distinct',Rule::unique('phone_numbers','phone')],
            'birthdate' => 'required|date',
            'address'=> 'required',
            'primaryEmail' => 'required',
            'primaryPhone' => 'required'
        ];
        $messages = [
            'email.*.unique' => 'A contact with this email id exists',
            'email.*.email' => 'It must be a valid email address',
            'primaryEmail.required' => 'Please select an email address as primary!',
            'primaryPhone.required' => 'Please select a phone number as primary!'
        ];
        Validator::make($request->all(),$rules,$messages,['first_name'=> 'first name','phone.*'=>'phone number', 'email.*'=>'email id','oldEmail.*'=>'email id'])->validate();
        $image = '';
        if($request->file('image') !== null) {
            $image = $request->file('image')->store('contacts');
        }
        $bday = new DateTime($request->birthdate);
        $contact = Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthdate' => $bday,
            'address' => $request->address,
            'image' => $image
        ]);
        $allEmail = new Collection();
        foreach ($request->email as $value) {
           if($value !== null) {
                $emailId = new EmailId;
                $emailId->email = $value;
                $emailId->primary = 0;
                $allEmail->push($emailId);
           }
        }
        head(head($allEmail->where('email',$request->primaryEmailId)))->primary=1;
        $contact->emailIds()->saveMany($allEmail);
        $allPhone = new Collection();
        foreach ($request->phone as $value) {
            if($value !== null){
                $phone = new PhoneNumber;
                $phone->phone = $value;
                $phone->primary = 0;
                $allPhone->push($phone);
            }
        }
        head(head($allPhone->where('phone',$request->primaryPhoneNumber)))->primary=1;
        $contact->phoneNumbers()->saveMany($allPhone);
        session()->flash('status','success');
        session()->flash('message','Contact added successfully');
        return redirect(route('contacts.index'));
    }

    public function show(Contact $contact)
    {
        return view('contact',compact(['contact']));
    }


    public function edit(Contact $contact)
    {
        return view('update-contact',compact('contact'));
    }


    public function update(Request $request, Contact $contact)
    {
        $oldEmail = $request->has('oldEmail') ? ($request->only('oldEmail'))['oldEmail'] : [];
        $oldPhone = $request->has('oldPhone') ?  $request->only('oldPhone')['oldPhone'] : [];

        $allEmailIds =  $contact->emailIds()->get()->sortByDesc('primary')->pluck('id');
        $allPhoneIds = $contact->phoneNumbers()->get()->sortByDesc('primary')->pluck('id');

        $emailIdsToBeDeleted = array_diff($allEmailIds->toArray(),array_keys($oldEmail));
        $phoneNosToBeDeleted = array_diff($allPhoneIds->toArray(),array_keys($oldPhone));

        EmailId::destroy($emailIdsToBeDeleted); // primary keys
        PhoneNumber::destroy($phoneNosToBeDeleted); // primary keys
        $contact->refresh();

        $emailTemp = array_merge($request->only('oldEmail'),$request->only('email'));
        $phoneTemp = array_merge($request->only('oldPhone'),$request->only('phone'));
        $request->merge(['emailTemp'=>$emailTemp,'phoneTemp' => $phoneTemp]);
        $rules = [
            'first_name' => 'required',
            'email.*' => ['sometimes','required','email','distinct',Rule::unique('email_ids','email')->ignore($contact->id,'contact_id')],
            'oldEmail.*' => ['sometimes','required','email','distinct',Rule::unique('email_ids','email')->ignore($contact->id,'contact_id')],
            'emailTemp.*.*' => 'distinct',
            'phone.*' => ['sometimes','required','numeric','min_digits:10','max_digits:10','distinct',Rule::unique('phone_numbers','phone')->ignore($contact->id,'contact_id')],
            'oldPhone.*' => ['sometimes','required','numeric','min_digits:10','max_digits:10','distinct',Rule::unique('phone_numbers','phone')->ignore($contact->id,'contact_id')],
            'phoneTemp.*.*' => 'distinct',
            'birthdate' => 'required|date',
            'address'=> 'required',
            'primaryEmail' => 'required',
            'primaryPhone' => 'required'
        ];
        $messages = [
            'email.*.unique' => 'A contact with this email id exists',
            'email.*.email' => 'It must be a valid email address',
            'primaryEmail.required' => 'Please select an email address as primary!',
            'primaryPhone.required' => 'Please select a phone number as primary!'

        ];
        Validator::make($request->all(),$rules,$messages,['first_name'=> 'first name','phone.*'=>'phone number','oldPhone.*'=>'phone number', 'email.*'=>'email id','oldEmail.*'=>'email id','emailTemp.*.*' =>'email id','phoneTemp.*.*'=>'phone number'])->validate();

        $data = $request->only(['first_name','last_name','address']);
        $bday = new DateTime($request->birthdate);
        $data['birthdate'] = $bday;
        $newEmail = [];
        $newPhone = [];
        if($request->has('email'))
        {
            $newEmail = $request->only('email');
            $newEmail = $newEmail['email'];
        }
        if($request->has('phone')) {
            $newPhone = $request->only('phone');
            $newPhone = $newPhone['phone'];
        }
        $ids = $allEmailIds;
        $temp = array_merge($oldEmail, $newEmail);
        $i = 0;
        $primary = 0;

        foreach($temp as $value)
        {
            $primary = 0;
            if($i < sizeof($ids)){
                $id = $ids[$i];
                $i++;
            } else {
                $id = null;
            }
            $primary = $value === $request->primaryEmailId ? 1 : 0;
            $contact->emailIds()->updateOrCreate(
                ['id'=>$id],
                ['email'=>$value, 'primary' => $primary]
            );
        }
        $ids = $allPhoneIds;
        $temp = array_merge($oldPhone, $newPhone);
        $i=0;
        foreach($temp as $value)
        {
            if($i < sizeof($ids)){
                $id = $ids[$i];
                $i++;
            } else {
                $id = null;
            }
            $primary = $value === $request->primaryPhoneNumber ? 1 : 0;
            $contact->phoneNumbers()->updateOrCreate(
                ['id'=>$id],
                ['phone'=>$value , 'primary' => $primary]
            );
        }

        if($request->has('image')){
            $image = $request->file('image')->store('contacts');
            $data['image'] = $image;
            $contact->deleteImage();
        }
        $contact->update($data);
        return redirect(route('contacts.index'));
    }
    public function destroy(Contact $contact)
    {
        if($contact->image !== 'contacts/contact.jpg') {
            $contact->deleteImage();
        }
        $contact->delete();
        session()->flash('status','success');
        session()->flash('message','Contact deleted successfully');
        return redirect(route('contacts.index'));
    }
}
