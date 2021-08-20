<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('public_email')->default("")->nullable();
            $table->string('telefoonnummer')->default("")->nullable();
            $table->string('twitter')->default("")->nullable();
            $table->string('facebook')->default("")->nullable();
            $table->string('snapchat')->default("")->nullable();
            $table->string('instagram')->default("")->nullable();
            $table->string('linkedin')->default("")->nullable();
            $table->string('tiktok')->default("")->nullable();
            $table->dateTime('geboortedatum')->default(date("d-m-y"))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
