<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailId extends Model
{
    use HasFactory;
    protected $fillable = ['email','primary'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function getIsPrimaryAttribute(){
        return $this->primary == 1;
    }
}
