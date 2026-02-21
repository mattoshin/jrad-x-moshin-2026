<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Plans;
use App\Models\Category;
use App\Models\User;
use App\Models\ControlChannel;
use App\Models\ControlCategories;

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
        Schema::create('ClientChannels', function (Blueprint $table){
        $table->id();
        $table->unsignedinteger('plan');
        $table->unsignedBigInteger('category');
        $table->unsignedBigInteger('controlCategory');
        $table->unsignedBigInteger('controlChannel');
        $table->string('channelId', 255);
        $table->boolean('enabled')->default(false);
        $table->timestamp('startDate')->now();
        $table->timestamp('updateDate')->nullable();
        $table->timestamp('endDate')->nullable();
        });
        Schema::table('ClientChannels', function(Blueprint $table)
        {
           $table->foreign('plan')
           ->references('id')
           ->on('plans')
           ->onUpdate('cascade')
           ->onDelete('cascade');

           $table->foreign('category')
           ->references('id')
           ->on('clientcategories')
           ->onUpdate('cascade')
           ->onDelete('cascade');

           $table->foreign('controlCategory')
           ->references('id')
           ->on('controlcategories')
           ->onUpdate('cascade')
           ->onDelete('cascade');

           $table->foreign('controlChannel')
           ->references('id')
           ->on('channels')
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
        Schema::dropIfExists('ClientChannels');
    }
};
