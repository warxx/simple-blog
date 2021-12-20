<?php

namespace App\Services;

use App\Services\Interfaces\TagServiceInterface;
use App\Tag;

class TagService implements TagServiceInterface
{
    public function __construct()
    {
    }

    public function saveTag($name) {
        $tag = new Tag();

        $tag->name = $name;
        $tag->save();
    }
}
