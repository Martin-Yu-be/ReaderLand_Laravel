<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function articles(): BelongsToMany 
    {
        return $this->belongsToMany(
            \App\Models\Article::class,
            'article_category',
            'category_id',
            'article_id', 
        );
    }
}
