<template>
  <div class="row">
    <div class="col-lg-9">
      <div class="card card-lyrics" id="cardLyrics">
        <div class="card-header p-1 song-links">
          <a
            v-if="renderScores"
            class="btn btn-secondary"
            :class="{'chosen': (topMode == 1)}"
            @click="topMode=(topMode==1)?0:1"
          >
            <i class="fas fa-file-alt"></i>
            <span class="d-none d-sm-inline">Noty</span>
          </a>
          <a
            v-if="renderTranslations"
            class="btn btn-secondary"
            :class="{'chosen': (topMode == 2)}"
            @click="topMode=(topMode==2)?0:2"
          >
            <i class="fas fa-language"></i>
            <span class="d-none d-sm-inline">Překlady</span> 
          </a>
          <!-- <a class="btn btn-secondary">
            <i class="fas fa-file-export"></i>
            <span class="d-none d-sm-inline">Export</span>
          </a>
          <a class="btn btn-secondary">
            <i class="far fa-star"></i>
            <span class="d-none d-sm-inline">Hvězdička</span>
          </a> -->
          <a class="btn float-right" title="Nahlásit" target="_blank" :href="[song_lyric?'https://docs.google.com/forms/d/e/1FAIpQLSdTaOCzzlfZmyoCB0I_S2kSPiSZVGwDhDovyxkWB7w2LfH0IA/viewform?entry.2038741493=' + encodeURI(song_lyric.name):'']">
            <i class="fas fa-exclamation-triangle p-0"></i>
          </a>
          <!-- scores -->
          <div v-show="topMode==1">
            <div class="overflow-auto toolbox toolbox-u">
              <a
                class="btn btn-secondary float-right fixed-top position-sticky cross"
                v-on:click="topMode=0"
              >
                <i class="fas fa-times pr-0"></i>
              </a>
              <div class="row ml-0" v-if="!$apollo.loading">
                <table class="table m-0 w-auto">
                  <external-line v-for="(score, index) in scores"
                  v-bind:key="index"
                  :index="index"
                  :url="score.url"
                  :name="score.public_name"
                  :type="score.type"
                  :authors="score.authors"
                  ></external-line>
                </table>
              </div>
              <div class="row" v-else>
                <span v-if="$apollo.loading">
                  <i>Načítám...</i>
                </span>
                <span v-else>
                  <i>Žádné noty nebyly nalezeny.</i>
                </span>
              </div>
            </div>
          </div>
          <!-- translations -->
          <div v-show="topMode==2">
            <div class="overflow-auto toolbox toolbox-u">
              <a
                class="btn btn-secondary float-right fixed-top position-sticky cross"
                v-on:click="topMode=0"
              >
                <i class="fas fa-times pr-0"></i>
              </a>
              <div class="row ml-0" v-if="!$apollo.loading">
                <table class="table m-0 w-auto">
                  <tr><th class="border-top-0"></th><th class="border-top-0">Název</th><th class="border-top-0">Typ</th><th class="border-top-0">Autor (překladu)</th></tr>
                  <translation-line
                  v-for="(translation, index) in song_lyric.song.song_lyrics.filter(lyric => lyric.type == 0)"
                  :translation="translation"
                  :original_name="song_lyric.name"
                  :key="index+'0'"
                  >
                  </translation-line>
                  <translation-line
                  v-for="(translation, index) in song_lyric.song.song_lyrics.filter(lyric => lyric.type == 2)"
                  :translation="translation"
                  :original_name="song_lyric.name"
                  :key="index+'1'"
                  >
                  </translation-line>
                  <translation-line
                  v-for="(translation, index) in song_lyric.song.song_lyrics.filter(lyric => lyric.type == 1)"
                  :translation="translation"
                  :original_name="song_lyric.name"
                  :key="index+'2'"
                  >
                  </translation-line>
                </table>
              </div>
              <div class="row" v-else>
                <span v-if="$apollo.loading">
                  <i>Načítám...</i>
                </span>
                <span v-else>
                  <i>Žádné překlady nebyly nalezeny.</i>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body py-2 pl-3 overflow-hidden">
          <div class="d-flex align-items-start justify-content-between">
              <div id="song-lyrics" :class="{'p-1': true, 'song-lyrics-extended': chordSharedStore.chordMode==2}">
                <!-- here goes the song lyrics (vue components generated as a string by Laravel) -->
                <div v-if="!$apollo.loading && song_lyric.capo > 0" class="mb-2">
                  <i>capo: {{ song_lyric.capo }}</i>
                </div>
                <a class="btn btn-secondary bg-transparent p-0 mb-3" v-if="chordSharedStore.nChordModes != 1 && chordSharedStore.chordMode == 0" @click="chordSharedStore.chordMode = 2">Zobrazit akordy</a>
                <a class="btn btn-secondary bg-transparent p-0 mb-3" v-if="chordSharedStore.chordMode != 0" @click="chordSharedStore.chordMode = 0">Skrýt akordy</a>
                <slot></slot>
              </div>
              <right-controls></right-controls>

              <!-- todo: preparing for two-column view -->
              <!-- <div id="song-lyrics" class="song-lyrics-divided">
                                <div class="row">
                                    <div class="col-sm-6 song-lyrics-refrains">
                                        <slot></slot>
                                    </div>
                                    <div class="col-sm-6 song-lyrics-verses">
                                        <slot></slot>
                                    </div>
                                </div>
              </div>-->
          </div>
        </div>
        
        <div
          class="controls fixed-bottom position-sticky p-1"
          v-bind:class="{'card-footer': controlsDisplay}"
        >
          <div v-show="bottomMode==1 && controlsDisplay">
            <div class="overflow-auto toolbox">
              <a class="btn btn-secondary float-right" v-on:click="bottomMode=0">
                <i class="fas fa-times pr-0"></i>
              </a>
              <div class="toolbox-item" v-if="chordSharedStore.nChordModes != 1" :class="{ 'hidden-toolbox-item': (chordSharedStore.chordMode == 0) }">
                <transposition v-model="chordSharedStore.transposition"></transposition>
              </div>

              <div class="toolbox-item" v-if="chordSharedStore.nChordModes != 1" :class="{ 'hidden-toolbox-item': (chordSharedStore.chordMode == 0) }">
                <chord-sharp-flat v-model="chordSharedStore.useFlatScale"></chord-sharp-flat>
              </div>

              <div class="toolbox-item" v-if="chordSharedStore.nChordModes != 1">
                <chord-mode v-model="chordSharedStore.chordMode" :n-chord-modes="chordSharedStore.nChordModes"></chord-mode>
              </div>

              <div class="toolbox-item">
                <font-sizer v-model="chordSharedStore.fontSizePercent"></font-sizer>
              </div>
            </div>
          </div>
          <!-- media -->
          <div v-show="bottomMode==2 && controlsDisplay">
            <div class="overflow-auto media-card toolbox">
              <a
                class="btn btn-secondary float-right fixed-top position-sticky cross"
                v-on:click="bottomMode=0"
              >
                <i class="fas fa-times pr-0"></i>
              </a>
              <div class="row ml-0 pt-2" v-if="hasExternalsOrFiles && !$apollo.loading">
                <div class="col-md-6" v-for="external in mediaExternals" v-bind:key="external.id">
                  <external-view
                    :url="external.url"
                    :media-id="external.media_id"
                    :type="external.type"
                    :authors="external.authors"
                  ></external-view>
                </div>
                <div class="col-md-6" v-for="file in mediaFiles" v-bind:key="file.id">
                  <external-view
                    :url="file.url"
                    :media-id="file.media_id"
                    :type="fileTypeConvert(file.type)"
                    :authors="file.authors"
                  ></external-view>
                </div>
              </div>
              <div v-else>
                <span v-if="$apollo.loading">
                  <i>Načítám...</i>
                </span>
                <span v-else>
                  <i>Žádná nahrávka nebyla nalezena.</i>
                </span>
              </div>
            </div>
          </div>
          <!-- control buttons -->
          <span v-show="controlsDisplay">
            <a
              class="btn btn-secondary"
              v-bind:class="{ 'chosen': bottomMode==1 }"
              v-on:click="bottomMode=(bottomMode==1)?0:1"
            >
              <i class="fas fa-sliders-h"></i>
              <span class="d-none d-sm-inline">Nástroje</span>
            </a>
            <a
              class="btn btn-secondary"
              v-if="renderMedia"
              v-bind:class="{ 'chosen': bottomMode==2 }"
              v-on:click="bottomMode=(bottomMode==2)?0:2"
            >
              <i class="fas fa-headphones"></i>
              <span class="d-none d-sm-inline">Nahrávky</span>
            </a>
            <div
              class="d-inline-block btn-group m-0"
              role="group"
              v-bind:class="{ 'chosen': autoscroll }"
            >
              <a class="btn btn-secondary" v-on:click="autoscroll=!autoscroll">
                <i
                  class="fas"
                  v-bind:class="[autoscroll?'pr-0 fa-stop-circle':'fa-arrow-circle-down']"
                ></i>
                <span class="d-none d-sm-inline" v-if="!autoscroll">Rolovat</span>
              </a><a class="btn btn-secondary" v-if="autoscroll" @click="autoscrollNum--" :class="{ 'disabled': autoscrollNum==1 }">-</a><a class="btn btn-secondary" v-if="autoscroll" @click="autoscrollNum++" :class="{ 'disabled': autoscrollNum==20 }">+</a>
            </div>
          </span>
          <a class="btn btn-secondary float-right" :title="[controlsDisplay?'Skrýt lišty':'Zobrazit lišty']" v-on:click="controlsToggle">
            <i
              class="fas pr-0"
              v-bind:class="[controlsDisplay?'fa-chevron-right':'fa-chevron-left']"
            ></i>
          </a>
        </div>
        <div class="card-footer p-1 song-links">
          <!-- todo: asset img -->
          <div class="px-3 py-2 d-inline-block">
            Zpěvník ProScholy.cz
            <img src="/img/logo_v2.png" width="20px">
            {{ new Date().getFullYear() }}
          </div>
          <a class="btn btn-secondary float-right" target="_blank" :href="[song_lyric?'https://docs.google.com/forms/d/e/1FAIpQLSdTaOCzzlfZmyoCB0I_S2kSPiSZVGwDhDovyxkWB7w2LfH0IA/viewform?entry.1714245491=' + song_lyric.id + '&entry.2038741493=' + encodeURI(song_lyric.name):'']">
            Nahlásit
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card card-blue mb-3 d-none d-lg-flex" v-on:click="topMode=1" v-if="renderScores">
        <slot name="score"></slot>
      </div>
      <div class="card card-green mb-3 d-none d-lg-flex" v-on:click="bottomMode=2" v-if="renderMedia">
        <slot name="media"></slot>
      </div>
      <div class="card mb-3 d-none d-lg-flex" v-on:click="bottomMode=1">
        <div class="card-header media-opener py-2 rounded bg-secondary text-white">
            <i class="fas fa-sliders-h"></i>
            Nastavit zobrazení
        </div>
        <div class="media-opener" v-if="chordSharedStore.nChordModes != 1"><i class="fas fa-angle-right"></i> Transpozice:  <span class="float-right">{{ chordSharedStore.transposition }}</span></div>
        <div class="media-opener" v-if="chordSharedStore.nChordModes != 1"><i class="fas fa-angle-right"></i> Posuvky:  <span class="float-right">{{ chordSharedStore.useFlatScale?"♭":"#" }}</span></div>
        <div class="media-opener" v-if="chordSharedStore.nChordModes != 1"><i class="fas fa-angle-right"></i> Akordy:  <span class="float-right">{{ chordSharedStore.chordMode?"+":"–" }}</span></div>
        <div class="media-opener"><i class="fas fa-angle-right"></i> Velikost písma: <span class="float-right">{{ (chordSharedStore.fontSizePercent - 100)/10 }}</span></div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
  .cross {
    z-index: 5;
  }

  .toolbox {
    padding: 0.25rem !important;
    margin-bottom: 0.25rem !important;

    background: white;
    .dark & {
      background: black;
    }

    &.toolbox-u {
      margin-top: 0.25rem !important;
      margin-bottom: 0 !important;
    }

    .toolbox-item {
      text-align: center;
      padding-left: 0.5rem;
      padding-right: 0.5rem;
      padding-bottom: 0.25rem;
      padding-top: 0.25rem;
      margin: 0.25rem;
      display: inline-block;
      border-radius: 0.125rem;
      border: 1px solid #dee2e6;

      &.hidden-toolbox-item {
        opacity: 0.3;
        pointer-events: none;
      }

      .dark & {
        border-color: #211d19;
      }
    }
  }

 .select-themed {
    background-color: white;
    padding: 0.5em;
    width: 100%;
  }

  .song-part-hidden {
    display: none;
  }

  .song-lyrics-extended .song-part-hidden {
    display: block;
  }



  .song-part-hidden-text {
    margin-bottom: 1em;

    .chord {
      display: none;
    }
  }

  .song-lyrics-extended .song-part-hidden-text {
    margin-bottom: 0;

    .chord {
      display: inline-block;
    }
  }
</style>


<script>
import { store } from "./store.js";

import FontSizer from "./FontSizer";
import ChordMode from "./ChordMode";
import ChordSharpFlat from "./ChordSharpFlat";
// import MediaOpener from './MediaOpener';
import RightControls from "./RightControls";
import Transposition from "./Transposition";
import TranslationLine from "./TranslationLine.vue";
import ExternalView from "Public/components/ExternalView.vue";
import ExternalLine from "Public/components/ExternalLine.vue";

// base_url = document.querySelector('#baseUrl').getAttribute('value');

import gql, { disableFragmentWarnings } from "graphql-tag";

const FETCH_SONG_LYRIC = gql`
  query($id: ID!) {
    song_lyric(id: $id) {
      id
      name
      externals(orderBy: { field: "type", order: ASC }) {
        id
        public_name
        url
        type
        media_id
        authors {
          id
          name
          public_url
        }
      }
      files {
        id
        public_name
        url
        type
        authors {
          id
          name
          public_url
        }
      }
      song {
        song_lyrics {
          id
          name
          public_url
          type
          authors {
            id
            name
            public_url
          }
          lang
          lang_string
        }
      }
      capo
      # songbook_records{number, songbook{id, name, shortcut}}
    }
  }
`;

import { clone } from 'lodash';

export default {
  props: ["song-id", "render-media", "render-scores", "render-translations"],

  components: {
    FontSizer,
    ChordMode,
    ChordSharpFlat,
    ExternalView,
    ExternalLine,
    RightControls,
    Transposition,
    TranslationLine
  },

  data() {
    // use this only in SongView and Chord component
    // use v-model to bind data from every other component
    return {
      controlsDisplay: true,
      bottomMode: 0,
      topMode: 0,
      autoscroll: false,
      autoscrollNum: 10,
      scrolldelay: null,
      fullscreen: false,
      selectedScoreIndex: 0,

      chordSharedStore: store
    }
  },

  watch: {
    autoscroll: function () {
      this.setScroll(this.autoscrollNum, this.autoscroll);
    },
    autoscrollNum: function () {
      this.setScroll(this.autoscrollNum, this.autoscroll);
    },
  },

  apollo: {
    song_lyric: {
      query: FETCH_SONG_LYRIC,
      variables() {
        return {
          id: this.songId
        };
      }
    }
  },

  computed: {
    hasExternalsOrFiles: {
      get() {
        return (
          this.song_lyric &&
          (this.song_lyric.externals || this.song_lyric.files) &&
          (this.song_lyric.externals.length || this.song_lyric.files.length)
        );
      }
    },

    mediaExternals: {
      get() {
        if (!this.hasExternalsOrFiles) return [];

        return this.song_lyric.externals.filter(ext =>
          [1, 2, 3, 7].includes(ext.type)
        );
      }
    },

    mediaFiles: {
      get() {
        if (!this.hasExternalsOrFiles) return [];

        return this.song_lyric.files.filter(file =>
          [1, 2, 3, 7].includes(this.fileTypeConvert(file.type))
        );
      }
    },

    scores: {
      get() {
        // File => File with unified type
        const mapFile = file => {
          const copy = clone(file);
          copy.type = this.fileTypeConvert(copy.type);
          return copy;
        };

        const filteredExternals = this.song_lyric.externals.filter(ext =>
          [4, 8, 9].includes(ext.type)
        );
        const filteredFiles = this.song_lyric.files
          .map(mapFile) 
          .filter(file => [4, 8, 9].includes(file.type));

        return [...filteredExternals, ...filteredFiles];
      }
    }
  },

  methods: {
    controlsToggle: function() {
      this.controlsDisplay = !this.controlsDisplay;
      document.querySelector(".navbar.fixed-top").classList.toggle("d-none");
    },

    fileTypeConvert: function(type) {
      const mapping = {
        1: 8,
        2: 9,
        3: 4,
        4: 7
      };

      return mapping[type] || type;
    },

    setScroll: function(num, condition) {
      clearInterval(this.scrolldelay);
      if(num > 0 && num < 21 && condition) {
        this.scrolldelay = setInterval(function() {window.scrollBy(0, 1);}, (21-num)*10);
      }
    },
  },

  mounted() {
    if(document.getElementById("song-lyrics").innerHTML.replace(/<[^>]+>/g, "").replace(/\s/g, "") == "") {
      document.getElementById("song-lyrics").innerHTML = "Text písně připravujeme.";
      if(this.renderMedia) {
        this.bottomMode = 2;
      }
      if(this.renderScores) {
        this.topMode = 1;
      } else if(this.renderTranslations) {
        this.topMode = 2;
      }
    }
  }
};
</script>

