<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'image',
        'birthdate'
    ];

    public function deleteImage(){
        Storage::delete($this->image);
    }

    public function phoneNumbers() {
        return $this->hasMany(PhoneNumber::class);
    }

    public function emailIds(){
        return $this->hasMany(EmailId::class);
    }
    
}
