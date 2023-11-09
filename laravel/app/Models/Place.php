<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'file_id',
        'latitude',
        'longitude',
        // 'category_id',
        // 'visibility_id',
        'author_id'
    ];
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    public function place()
    {
        return $this->hasOne(Place::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }

}
