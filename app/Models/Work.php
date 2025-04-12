<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_fa', 'title_en', 'description_fa', 'description_en', 'cover_image',
    ];

    public function teamMembers()
    {
        return $this->belongsToMany(TeamMember::class)->withPivot('member_role')->withTimestamps();
    }
}
