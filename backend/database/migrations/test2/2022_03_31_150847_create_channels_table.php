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
        Schema::create('channels', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('category');
            $table->bigInteger('channel_id')->nullable();
            $table->unsignedBigInteger('product');
            $table->char('name',255)->nullable();
        });
        Schema::table('channels', function(Blueprint $table){
            $table->foreign('product')->references('id')->on('Products');
            
            $table->foreign('category')
            ->references('id')
            ->on('ControlCategories');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
};
