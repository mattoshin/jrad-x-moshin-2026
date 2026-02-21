<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Channels;
use App\Models\User;

return new class extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('plan')->nullable();
            $table->char('webhook_url',255)->nullable();
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->unsignedBigInteger('user')->nullable();
            $table->boolean('enabled')->default(0)->nullable();

           

        });
        Schema::table('webhooks',function (Blueprint $table) {
            $table->foreign('channel_id')
            ->references('id')->on('channels');

            $table->foreign('user')
            ->references('id')->on('users');


            $table->foreign('plan')
            ->references('id')
            ->on('plans');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhooks');
    }
};
