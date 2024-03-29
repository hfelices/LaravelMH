<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function liked()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    public function likes()
    {
       return $this->belongsToMany(Post::class, 'likes');
    }
}
