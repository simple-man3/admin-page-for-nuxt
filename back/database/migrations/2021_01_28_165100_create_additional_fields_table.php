<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active');
            $table->string('symbol_code')->unique();
            $table->boolean('needFill');

            $table->bigInteger('type_fields_id')->unsigned();
            $table->foreign('type_fields_id')->references('id')->on('type_fields');

            $table->bigInteger('info_block_id')->unsigned();
            $table->foreign('info_block_id')->references('id')->on('info_blocks');

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
        Schema::dropIfExists('additional_fields');
    }
}
