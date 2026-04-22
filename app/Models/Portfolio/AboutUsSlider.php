<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsSlider extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image_path', 'order'];
}
