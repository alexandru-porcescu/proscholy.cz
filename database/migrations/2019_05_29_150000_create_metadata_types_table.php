<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->smallInteger("data_type", false, true);
            $table->boolean("for_song_lyrics")->default(false);
            $table->boolean("for_authors")->default(false);
            $table->boolean("for_externals")->default(false);
            $table->boolean("for_files")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_types');
    }
}
