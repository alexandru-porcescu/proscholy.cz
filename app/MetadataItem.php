<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class MetadataItem extends Model
{
    protected $fillable = ["value", "metadata_type_id"];

    public function metadata_type()
    {
        return $this->belongsTo(MetadataType::class);
    }
}
