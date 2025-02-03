<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{
    use HasFactory;
    protected $fillable = ['category_name'];
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    public static function getCategory(){
        $categories = self::all();
        return $categories;
    }

    public static function getCategoryById(int $category_id){
        $categories = self::find($category_id);
        return $categories;
    }

    public static function createCategory($data){
        $categories = self::create($data);
        return $categories;
    }

    public static function updateCategory(int $category_id, $data){
        $categories = self::find($category_id);
        $categories->update($data);
        return $categories;
    }

    public static function deletCategory(int $category_id){
        $categories = self::find($category_id);
        if($categories){
            $categories->delete();
            return $categories;
        }
        return null;
    }
    public function products(){
        return $this->hasMany(ProductModel::class,'product_category_id','category_id');
    }
}


