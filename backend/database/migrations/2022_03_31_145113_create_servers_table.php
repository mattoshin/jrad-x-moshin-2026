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
        Schema::create('servers', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('guild_id')->unique()->default(20);
            $table->unsignedBigInteger('owner')->nullable();
            $table->string('name');
            $table->integer('business')->unsigned();
            $table->string('server_avatar')->nullable();

        });
        Schema::table('servers',function(Blueprint $table){
            $table->foreign('owner')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('business')
            ->references('id')
            ->on('businesses')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
};
