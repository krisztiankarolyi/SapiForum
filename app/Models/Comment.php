<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;


    protected $fillable = ['user_id', 'post_id', 'content', 'img_ref', 'added_at'];

    // Use the $attributes property to set default values
    protected $attributes = [
        'img_ref' => '',
    ];

    // Use mutators to format data before saving to the database
    public function setAddedAtAttribute($value)
    {
        $this->attributes['added_at'] = Carbon::parse($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
