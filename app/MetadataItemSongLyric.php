<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetadataItemSongLyric extends MetadataItem
{
    protected $table = "metadata_item_song_lyric";

    public function song_lyric()
    {
        return $this->belongsTo(SongLyric::class);
    }
}