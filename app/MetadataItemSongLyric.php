<?php

namespace App;

class MetadataItemSongLyric extends MetadataItem
{
    protected $table = "metadata_item_song_lyric";

    public function song_lyric()
    {
        return $this->belongsTo(SongLyric::class);
    }
}