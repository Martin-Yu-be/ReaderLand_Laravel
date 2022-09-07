<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);        
    }

    public function categories(): BelongsToMany 
    {
        return $this->belongsToMany(
            \App\Models\Category::class,
            // 'article_category',
            // 'article_id',
            // 'category_id',
        );
    }
}
