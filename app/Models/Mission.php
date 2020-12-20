<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    public function ninja(){
        return $this->belongsTo(Ninja::class);
    }

    public function mission(){
        return $this->belongTo(Mission::class);
    }

    public function missions_ninjas(){
        return $this->hasMany(MissionsNinjas::class);
    }
}
