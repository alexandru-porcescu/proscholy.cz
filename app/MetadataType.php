<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetadataType extends Model
{
    protected $fillable = ["name", "data_type", "for_song_lyrics", "for_authors", "for_externals", "for_files"];

    public function scopeForSongLyrics($query)
    {
        return $query->where("for_song_lyrics", true);
    }

    public function scopeForExternals($query)
    {
        return $query->where("for_externals", true);
    }

    public function scopeForFiles($query)
    {
        return $query->where("for_files", true);
    }

    public function scopeForAuthors($query)
    {
        return $query->where("for_authors", true);
    }
}
