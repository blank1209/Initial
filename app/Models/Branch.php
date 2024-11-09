<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'branchID';

    protected $table = 'branches';

    protected $guarded = [];

    public function branches(){
        return $this->belongsToMany(Branch::class);
    }

    public function users(){
        return $this->belongsTo(User::class, 'contactPerson', 'id');
    }

    public function sales(){
        return $this->hasMany(Sale::class, 'branch', 'branchID');
    }
}

