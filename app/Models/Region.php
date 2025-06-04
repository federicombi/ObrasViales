<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /** @use HasFactory<\Database\Factories\RegionFactory> */
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];
    
    public $timestamps = false;
    
    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function constructions(){
        return $this->hasMany(Construction::class);
    }
}
