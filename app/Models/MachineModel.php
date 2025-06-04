<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineModel extends Model
{
    /** @use HasFactory<\Database\Factories\MachineModelFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public $timestamps = false;

    public function machine_type(){
        return $this->belongsTo(MachineType::class);
    }

    public function machine_brand(){
        return $this->belongsTo(MachineBrand::class);
    }

    public function machines(){
        return $this->hasMany(Machine::class);
    }
    
}
