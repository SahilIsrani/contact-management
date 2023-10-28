<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;
    protected $fillable = ['id','phone','primary'];
    public function contacts() {
        return $this->belongsToMany(Contact::class);
    }

    public function getIsPrimaryAttribute(){
        return $this->primary == 1;
    }
}
