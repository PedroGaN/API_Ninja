<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ninja extends Model
{
    use HasFactory;

    public function mission(){
        return $this->belongTo(Mission::class);
    }

}
