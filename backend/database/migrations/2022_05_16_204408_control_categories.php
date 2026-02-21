<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Products;

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
    Schema::create('controlcategories',function(Blueprint $table){
        $table->id();
        $table->unsignedBigInteger('product')->nullable();
        $table->string('categoryId');
        $table->string('name')->nullable();
        $table->boolean('enabled')->default(false);
        $table->timestamp('startDate')->now();
        $table->timestamp('updateDate')->nullable();
        $table->timestamp('endDate')->nullable();
        $table->string('type');

        });
        Schema::table('controlcategories', function(Blueprint $table)
        {
         
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
        //
        Schema::dropIfExists('ControlCategories');
    }
};
