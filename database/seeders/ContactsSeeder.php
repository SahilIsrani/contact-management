<?php

namespace Database\Seeders;

use App\Models\Contact;
use Faker\Generator as Faker;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        // $contacts = Contact::factory(3)->create();
            for($i = 1; $i<=100; $i++) {
                $contact = Contact::factory()->hasEmailIds(random_int(1,4))->hasPhoneNumbers(random_int(1,4))->create();
                $relation = $contact->emailIds()->first();
                $relation->primary = 1;
                $relation->save();
                $relation = $contact->phoneNumbers()->first();
                $relation->primary = 1;
                $relation->save();
            }
    }
}
