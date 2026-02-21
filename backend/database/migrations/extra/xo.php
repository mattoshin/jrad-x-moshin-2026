<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
Schema::table('channels', function (Blueprint $table) {
    $table->foreign('product')
    ->references('id')
    ->on('products')
    ->onUpdate('cascade')
    ->onDelete('cascade');
});
