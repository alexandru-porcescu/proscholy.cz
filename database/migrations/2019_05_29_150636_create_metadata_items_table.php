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
        Schema::create('metadata_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("model_id");
            $table->string("model_type");
            $table->unsignedInteger("metadata_type_id");
            $table->text("value")->nullable();
            $table->timestamps();

            $table->foreign('metadata_type_id')->references('id')->on('metadata_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index(array('model_id', 'model_type'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_items');
    }
}
