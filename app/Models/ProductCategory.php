<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'categoryID';

    protected $table = 'product_categories';

    protected $guarded = [];

    public function productcategories(){
        return $this->hasMany(ProductCategory::class, 'productCategory', 'categoryID');
    }

    public function products(){
        return $this->hasMany(Product::class, 'productCategory', 'categoryID');
    }
}
