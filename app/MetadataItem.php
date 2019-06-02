<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetadataItem extends Model
{
    protected $fillable = ["value", "metadata_type_id"];

    public function metadata_type()
    {
        return $this->belongsTo(MetadataType::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
