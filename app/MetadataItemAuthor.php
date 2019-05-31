<?php

namespace App;

class MetadataItemAuthor extends MetadataItem
{
    protected $table = "metadata_item_author";

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}