<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'intro_text', 'image_path', 'email'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
