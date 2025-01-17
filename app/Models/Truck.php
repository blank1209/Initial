<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'trucks';

    protected $primaryKey = 'truckID';

    protected $guarded = [];

    public function trucks(){
        return $this->belongsToMany(Truck::class);
    }
}
