<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('adhaar_info_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid');
            $table->string('adhaar', 12);
            $table->text('additional_info')->nullable();
            $table->timestamps();

            $table->foreign('uid')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adhaar_info_data');
    }
};
