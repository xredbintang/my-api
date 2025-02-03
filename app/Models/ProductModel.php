<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


    class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $guarded = [];

    
    public static function deleteProduct (int $product_id) {
        $product = self::find($product_id);
        if($product){
            $product->delete();
            return $product;
        }
        return null;
    }

    public function category(){
        return $this->belongsTo(CategoriesModel::class, 'product_category_id', 'category_id');
    }
}

