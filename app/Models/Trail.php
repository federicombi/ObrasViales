<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trail extends Model
{
    /** @use HasFactory<\Database\Factories\TrailFactory> */
    use HasFactory;

    protected $fillable = [
        'km',
        'date',
        'use_time',
    ];
    protected $casts = [
        'date' => 'date',
    ];
        
    public $timestamps = false;

    public function machine(){
        return $this->belongsTo(Machine::class);
    }
}
