<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'title',
        'content',
        'tools_used',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
