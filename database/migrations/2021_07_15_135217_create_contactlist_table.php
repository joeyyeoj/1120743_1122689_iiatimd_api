<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactlist', function (Blueprint $table) {
            $table->unsignedBigInteger('ownerId');
            $table->foreign('ownerId')->references('id')->on('users');
            $table->unsignedBigInteger('contactId');
            $table->foreign('contactId')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactlist');
    }
}
