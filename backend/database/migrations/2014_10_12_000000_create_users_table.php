<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('discord_id')->unique()->default(20);

            $table->string('username')->index();

            $table->string('email')->unique();
            $table->string('avatar')->nullable();

            $table->string('expires_in');
            $table->string('refresh_token')->nullable();
            $table->boolean('admin')->default(false);
            $table->string('api_token')->nullable();

            $table->string('access_token')->nullable();
            $table->string('stripe_customer')->nullable();
            $table->timestamp('creationDate')->now();
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
