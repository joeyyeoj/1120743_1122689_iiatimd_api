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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('publieke_email')->default('Geen email opgegeven');
            $table->string('telefoonnummer')->default('Geen telefoonnummer opgegeven');
            $table->string('twitter')->default('Geen Twitter opgegeven');
            $table->string('facebook')->default('Geen Facebook opgegeven');
            $table->string('snapchat')->default('Geen Snapchat opgegeven');
            $table->string('instagram')->default('Geen Instagram opgegeven');
            $table->string('linkedin')->default('Geen LinkedIn opgegeven');
            $table->string('tiktok')->default('Geen TikTok opgegeven');
            $table->string('geboortedatum')->default('Geen geboortedatum opgegeven');
            $table->string('adres')->default('Geen adres opgegeven');
            $table->string('woonplaats')->default('Geen woonplaats opgegeven');
            $table->string('postcode')->default('Geen postcode opgegeven');
            $table->string('land')->default('Geen land opgegeven');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
