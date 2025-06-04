<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineBrand extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;

    public function machine_models(){
        return $this->hasMany(MachineModel::class);
    }

}
