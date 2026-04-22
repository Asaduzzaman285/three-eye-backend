<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    
    protected $fillable = ['left_image_path', 'right_title', 'right_description'];

    public function slides()
    {
        return $this->hasMany(AboutUsSlide::class, 'about_us_id')->orderBy('order');
    }
}
