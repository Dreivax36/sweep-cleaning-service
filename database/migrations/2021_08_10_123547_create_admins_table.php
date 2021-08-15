<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('email');
            $table->text('password');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->text('service_name');
            $table->text('service_description');
            $table->text('property_type');
            $table->timestamps();
        });

        Schema::create('residentials', function (Blueprint $table) {
            $table->id();
            $table->text('price');
            $table->timestamps();
        });

        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->text('price');
            $table->timestamps();
        });

        Schema::create('condominiums', function (Blueprint $table) {
            $table->id();
            $table->text('price');
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
        Schema::dropIfExists('admins');
    }
}
