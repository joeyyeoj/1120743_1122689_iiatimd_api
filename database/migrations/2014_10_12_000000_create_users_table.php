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
            $table->string('public_email')->default("");
            $table->string('telefoonnummer')->default("");
            $table->string('twitter')->default("");
            $table->string('facebook')->default("");
            $table->string('snapchat')->default("");
            $table->string('instagram')->default("");
            $table->string('linkedin')->default("");
            $table->string('tiktok')->default("");
            $table->date('geboortedatum')->default("");
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
