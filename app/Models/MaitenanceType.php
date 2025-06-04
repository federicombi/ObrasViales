<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaitenanceType extends Model
{
    protected $fillable = [
        'name',
        'km_limit',
    ];
    
    public $timestamps = false;

    public function maitenances(){
        return $this->hasMany(Maitenance::class);
    }
}

