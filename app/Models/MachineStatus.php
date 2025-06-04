<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineStatus extends Model
{
    
    protected $fillable = [
        'name',
    ];
    
    public $timestamps = false;

    public function machines(){
        return $this->hasMany(Machine::class);
    }
}
