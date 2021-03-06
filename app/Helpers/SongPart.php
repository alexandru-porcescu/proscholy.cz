<?php

namespace App\Helpers;
use Log;

class SongPart{

    protected $type;
    protected $is_hidden;
    protected $is_hidden_text;
    protected $inner_text = ""; 
    protected $song_lines = [];
    protected $ch_queue;

    function __construct($type, ChordQueue $chQueue, $is_hidden = false, $is_hidden_text = false)
    {
        $this->type = $type;
        $this->is_hidden = $is_hidden;
        $this->is_hidden_text = $is_hidden_text;
        $this->ch_queue = $chQueue;

        if ($this->isVerse()) {
            $this->ch_queue->notifyVerse($this->getVerseNumber());
        }
    }

    function isHidden() {
        return $this->is_hidden;
    }

    function isHiddenText() {
        return $this->is_hidden_text;
    }

    function isEmpty() {
        // strip new lines
        $text = str_replace('\n', "", $this->inner_text);

        // strip whitespaces
        $text = trim($text);

        return $text == "";
    }

    function setHidden(bool $val) {
        $this->is_hidden = $val;
    }

    function setHiddenText(bool $val) {
        $this->is_hidden_text = $val;
    }

    function getType() {
        return $this->type;
    }

    function getSongPartTag() {
        if ($this->isVerse()) {
            return $this->getVerseNumber() . '.&nbsp;';
        }

        if ($this->type == 'P') {
            return '<i>předehra:</i>&nbsp;';
        }

        if ($this->type == 'M') {
            return '<i>mezihra:</i>&nbsp;';
        }

        if ($this->type == "") {
            return "";
        }

        // bridge, refrain, coda
        return $this->type . ":&nbsp;";
    }

    function isVerse() {
        return is_numeric($this->type);
    }

    function getVerseNumber() : int {
        return (int)$this->type;
    }

    function isRefrain() {
        return strlen($this->type) > 0 && $this->type[0] == "R";
    }

    function isInline() {
        return $this->type == "P" || $this->type == "M";
    }

    function isUndefined() {
        return $this->type == "";
    }

    function appendLine($line) {
        $this->inner_text .= $line . '\n';
        $this->song_lines[] = new SongLine($line, $this->ch_queue);
    }

    function toHTML()
    {
        $class = "song-part";
        $class .= $this->isRefrain() ? " song-part-refrain" : "";
        $class .= $this->isHidden() ? " song-part-hidden" : "";
        $class .= $this->isHiddenText() ? " song-part-hidden-text" : "";
        $class .= $this->isInline() ? " song-part-inline" : "";

        $html = '<div class="' . $class .'">';

        for ($i = 0; $i < count($this->song_lines); $i++) {
            $line = $this->song_lines[$i];

            if ($i == 0 && $this->type !== "") {
                $html .= $line->toHTML($this->getSongPartTag());
            } else {
                $html .= $line->toHTML();
            }
        }

        $html .= '</div>';

        return $html;
    }

    public function __toString()
    {
        return $this->type . ": " . $this->inner_text;
    }
}
