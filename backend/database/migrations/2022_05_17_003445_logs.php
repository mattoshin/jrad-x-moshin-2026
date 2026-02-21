<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Servers;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Logs', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('server')->nullable();
            $table->string('type', 255)->nullable();
            $table->text('log')->nullable();
            $table->timestamp('creationDate')->now();
            $table->timestamp('joinDate')->nullable();
        });


        Schema::table('Logs', function(Blueprint $table)
        {
           $table->foreign('server')
           ->references('id')
           ->on('servers')
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
        //
        Schema::dropIfExists('Logs');
    }
};
