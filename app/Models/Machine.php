<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    /** @use HasFactory<\Database\Factories\MachineFactory> */
    use HasFactory;

    protected $fillable = [
        'series',
    ];

    public function machine_model(){
        return $this->belongsTo(MachineModel::class);
    }

    public function machine_status(){
        return $this->belongsTo(MachineStatus::class);
    }

    public function allocations(){
        return $this->hasMany(Allocation::class)->orderBy('start_date', 'desc');
    }

    public function maitenances(){
        return $this->hasMany(Maitenance::class);
    }

    public function trails(){
        return $this->hasMany(Trail::class);
    }

}
