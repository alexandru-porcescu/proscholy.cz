<?php

namespace App;

class MetadataItemExternal extends MetadataItem
{
    protected $table = "metadata_item_external";

    public function external()
    {
        return $this->belongsTo(External::class);
    }
}