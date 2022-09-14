<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id')->unsigned()->unique();
            $table->tinyInteger('type');
            $table->decimal('price');
            $table->decimal('price_24h');
            $table->decimal('price_7d');
            $table->decimal('price_30d');
            $table->timestamps();
        });
        Schema::table('prices', function($table) {
            $table->foreign('asset_id')->on('assets')->references('id')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};
