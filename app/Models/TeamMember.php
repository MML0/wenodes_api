<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory; // <-- optional, if you want to seed test data.

    protected $fillable = [
        'user_id',
        'role',
        'bio_fa',
        'bio_en',
        'name_fa',
        'name_en',
        'profile_image_url' // Added profile url img
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function works()
    {
        return $this->belongsToMany(Work::class)->withPivot('member_role')->withTimestamps();
    }
    
}
