<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = ['title', 'body'];

    public function tags()  {
        return $this->belongsToMany(Tag::class);
    }
}
