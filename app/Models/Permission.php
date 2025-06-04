<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
    ];
    
    public $timestamps = false;

    public function users(){
        return $this->belongsToMany(User::class);
    }

}
