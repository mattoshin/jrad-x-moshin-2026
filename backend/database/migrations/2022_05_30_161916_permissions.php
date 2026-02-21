<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Business;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user')->nullable();
            $table->unsignedinteger('business')->nullable();
            $table->unsignedBigInteger('server')->nullable();
            $table->string('permission',255);
            $table->string('permission_token',255);
            $table->timestamp('last_update');
            
        });
        Schema::table('permissions', function(Blueprint $table)
        {
            $table->foreign('user')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('business')
            ->references('id')
            ->on('businesses')
            ->onUpdate('cascade')
            ->onDelete('cascade');

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
        Schema::dropIfExists('permissions');
    }
};
