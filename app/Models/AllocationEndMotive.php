<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllocationEndMotive extends Model
{
    protected $fillable = [
        'motive',
    ];
    
    public $timestamps = false;

    public function allocations(){
        return $this->hasMany(Allocation::class);
    }

}
