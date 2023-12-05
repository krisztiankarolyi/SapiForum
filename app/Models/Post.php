<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['user_id', 'category', 'title', 'content', 'img_ref'];

    // Use the $attributes property to set default values
    protected $attributes = [
        'img_ref' => '',
    ];

    // Use mutators to format data before saving to the database
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

}
