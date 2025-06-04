<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];
    
    public $timestamps = false;

    public function machine_models(){
        return $this->hasMany(MachineModel::class);
    }
}
