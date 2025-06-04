<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maitenance extends Model
{

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public $timestamps = false;


    public function maitenance_type(){
        return $this->belongsTo(MaitenanceType::class);
    }

    public function machine(){
        return $this->belongsTo(Machine::class);
    }

}
