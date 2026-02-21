<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedBigInteger('owner')->nullable();
            $table->char('name')->nullable();
            $table->char('email')->nullable();
            $table->char('twitter')->nullable();
           

        });
       Schema::table('businesses' , function(Blueprint $table)
        {

            $table->foreign('owner')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('set null');
            $table->char('stripeCustomer')->nullable();
            $table->text('description')->nullable();
            $table->char('location')->nullable();
            $table->char('currency')->nullable();
            $table->char('website')->nullable();
            $table->char('phone')->nullable();
            $table->boolean('notifications')->default(false);
            $table->boolean('order_confirmation')->default(false);
            $table->boolean('order_status')->default(false);
            $table->boolean('order_delivered')->default(false);
            $table->timestamp('creationDate')->default(now());
            $table->timestamp('updateDate')->nullable();
            $table->string('api_token')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
