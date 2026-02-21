<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Business;
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
        Schema::create('invoices', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user')->nullable();
            $table->unsignedinteger('business')->nullable();
            $table->unsignedBigInteger('product')->nullable();
            $table->string('sub', 255)->nullable();
            $table->string('stripe_tid')->nullable();
            $table->unsignedinteger('plan')->nullable();
            $table->char('billing_name')->nullable();
            $table->char('billing_address')->nullable();
            $table->char('billing_email')->nullable();
            $table->char('invoice_url')->nullable();
            $table->char('pay_method')->nullable();
            $table->float('pay_amount')->nullable();
            $table->boolean('paid')->nullable();
            $table->timestamp('creationDate')->now();
            $table->timestamp('joinDate')->nullable();
        });

        Schema::table('invoices', function(Blueprint $table)
        {
            $table->foreign('user')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('set null');
 
           $table->foreign('business')
           ->references('id')
           ->on('businesses')
           ->onUpdate('cascade')
           ->onDelete('set null');

           $table->foreign('product')
           ->references('id')
           ->on('products')
           ->onUpdate('cascade')
           ->onDelete('set null');

           $table->foreign('plan')
           ->references('id')
           ->on('plans')
           ->onUpdate('cascade')
           ->onDelete('set null');

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
        Schema::dropIfExists('invoices');
    }
};
