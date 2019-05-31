<?php

namespace App;

class MetadataItemFile extends MetadataItem
{
    protected $table = "metadata_item_file";

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}