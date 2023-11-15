<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'place_id',
    ];
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function favorites()
    {
       return $this->belongsToMany(Place::class, 'favorites');
    }
}
