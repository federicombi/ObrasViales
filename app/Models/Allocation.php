<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    /** @use HasFactory<\Database\Factories\AllocationFactory> */
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function machine(){
        return $this->belongsTo(Machine::class);
    }

    public function construction(){
        return $this->belongsTo(Construction::class);
    }

    public function allocation_end_motive(){
        return $this->belongsTo(AllocationEndMotive::class);
    }

}
