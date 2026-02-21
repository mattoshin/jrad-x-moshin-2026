<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Categories;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('category_id');
            $table->char('name',255);
            $table->text('description')->nullable();
            $table->char('stripeProduct')->nullable();
            $table->char('stripePid')->nullable();
            $table->float('price')->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('visible')->nullable();
            $table->boolean('enabled')->nullable();
            $table->boolean('trial')->nullable();
            $table->string('channel_type')->nullable();
            $table->integer('trial_period')->nullable();
             
        });
        Schema::table('products', function (Blueprint $table){
            $table->foreign('category_id')
            ->references('id')
            ->on('categories');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
