<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Категория статьи
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){

        //статья принадлежит категории
        return $this->belongsTo(BlogCategory::class);
    }

    public function user(){

        //Статья принадлежит пользователю
        return $this->belongsTo(User::class);
    }
}
