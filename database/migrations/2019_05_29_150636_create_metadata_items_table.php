<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_item_song_lyric', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("song_lyric_id");
            $table->unsignedInteger("metadata_type_id");
            $table->longText("value");
            $table->timestamps();

            $table->foreign('song_lyric_id')->references('id')->on('song_lyrics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('metadata_type_id')->references('id')->on('metadata_types')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('metadata_item_author', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("author_id");
            $table->unsignedInteger("metadata_type_id");
            $table->longText("value");
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('metadata_type_id')->references('id')->on('metadata_types')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('metadata_item_external', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("external_id");
            $table->unsignedInteger("metadata_type_id");
            $table->longText("value");
            $table->timestamps();

            $table->foreign('external_id')->references('id')->on('externals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('metadata_type_id')->references('id')->on('metadata_types')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('metadata_item_file', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("file_id");
            $table->unsignedInteger("metadata_type_id");
            $table->longText("value");
            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('metadata_type_id')->references('id')->on('metadata_types')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_item_song_lyric');
        Schema::dropIfExists('metadata_item_author');
        Schema::dropIfExists('metadata_item_external');
        Schema::dropIfExists('metadata_item_file');
    }
}
