<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'full_name',
        'email',
        'parents_name',
        'present_address',
        'permanent_address',
        'education',
        'experience',
        'position',
        'current_salary',
        'expected_salary',
        'social_links',
        'image_path',
        'resume_path',
        'status'
    ];

    protected $casts = [
        'education' => 'array',
        'social_links' => 'array',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
