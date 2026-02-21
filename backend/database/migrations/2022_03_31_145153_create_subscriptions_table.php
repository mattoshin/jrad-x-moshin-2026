<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Servers;
use App\Models\Plans;
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
        Schema::create('user-subscriptions', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedBigInteger('product')->nullable();
            $table->unsignedBigInteger('user')->nullable();
            $table->unsignedinteger('business')->nullable();
            $table->char('stripe_sid', 255);
            $table->char('stripe_pid', 255);
            $table->float('pay_amount')->nullable();
            $table->timestamp('creationDate')->now();
            $table->timestamp('endDate')->nullable()->default(null);
        });
        Schema::table('user-subscriptions', function(Blueprint $table)
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
            $table->foreign('product')
             ->references('id')
             ->on('products')
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
        Schema::dropIfExists('user-subscriptions');
    }
};
