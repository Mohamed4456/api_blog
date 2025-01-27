<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];



public function user()
{
    return $this->belongsTo(User::class);
}


}
