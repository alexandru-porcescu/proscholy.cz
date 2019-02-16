<?php

namespace App\Http\Controllers;

use App\Song;
use App\SongLyric;
use Illuminate\Http\Request;

class SongLyricsController extends Controller
{
    public function render($id)
    {
        $song_l = SongLyric::findOrFail($id);
        $song_l->visits += 1;
        $song_l->save();

        foreach ($song_l->authors as $author) {
            $author->visits += 1;
            $author->save();
        }

        return view('song_lyrics', compact('song_l'));
    }
}