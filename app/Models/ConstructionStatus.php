<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Construction;


class ConstructionStatus extends Model
{
    /** @use HasFactory<\Database\Factories\ConstructionStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public $timestamps = false;

    public function constructions(){
        return $this->hasMany(Construction::class);
    }
}
