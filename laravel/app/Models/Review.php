<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'place_id',
        'body'
    ];
    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function place()
    {
        return $this->hasOne(Place::class);
    }
    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
    
}
