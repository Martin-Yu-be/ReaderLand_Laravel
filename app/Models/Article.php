<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = ['pivot'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class)->select(['name','id', 'bio', 'picture']);        
    }

    public function categories(): BelongsToMany 
    {
        return $this->belongsToMany(\App\Models\Category::class)->select('category');
    }
}
