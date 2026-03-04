<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    protected $table = 'category_products'; 

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); 
    }
}