<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Business;
use App\Models\Products;
use App\Models\Subscriptions;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedBigInteger('user')->nullable();
            $table->unsignedinteger('business')->nullable();
            $table->unsignedBigInteger('product')->nullable();
            $table->unsignedinteger('subscription')->nullable();
            $table->char('name', 255)->nullable();
            $table->char('color', 255)->nullable();
            $table->char('picture', 255)->nullable();
            $table->timestamp('startDate')->default(now());
            $table->timestamp('endDate')->nullable();
            $table->char('role', 255)->nullable();
            $table->boolean('hadTrial')->default(false);
            $table->boolean('activeTrial')->default(false);
            $table->timestamp('trialStartDate')->nullable()->default(now());
            $table->timestamp('trialEndDate')->nullable();
        });
        Schema::table('plans', function(Blueprint $table)
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
        
            $table->foreign('subscription')
            ->references('id')
            ->on('user-subscriptions')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('product')
            ->references('id')
            ->on('products')
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
        Schema::dropIfExists('plans');
    }
};
