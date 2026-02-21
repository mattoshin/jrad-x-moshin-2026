<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Products;
use App\Models\Plans;

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
        Schema::create('Orders', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user')->nullable();
            $table->unsignedBigInteger('product')->nullable();
            $table->string('sub', 255)->nullable();
            $table->integer('stripeTId')->nullable();
            $table->unsignedinteger('plan')->nullable();
            $table->char('billing_name')->nullable();
            $table->char('billing_address')->nullable();
            $table->char('billing_email')->nullable();
            $table->char('pay_method')->nullable();
            $table->float('pay_amount')->nullable();
            $table->timestamp('creationDate')->now();
            $table->timestamp('joinDate')->nullable();
        });

        Schema::table('Orders', function(Blueprint $table)
        {
           $table->foreign('user')
           ->references('id')
           ->on('users');

           $table->foreign('business')
           ->references('id')
           ->on('businesses');

           $table->foreign('product')
           ->references('id')
           ->on('products');

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
        //Schema::dropIfExists('Orders');
        Schema::dropIfExists('Orders');
    }
};
