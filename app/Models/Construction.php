<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
///use App\Models\ConstructionStatus;


class Construction extends Model
{
    /** @use HasFactory<\Database\Factories\ConstructionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'initial_end_date',
        'end_date',
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'initial_end_date' =>'date',
        'end_date' => 'date',
    ];

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function construction_status(){
        return $this->belongsTo(ConstructionStatus::class);
    }

    public function allocations(){
        return $this->hasMany(Allocation::class);
    }
}
