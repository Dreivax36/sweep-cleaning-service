<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedCleanersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_cleaners', function (Blueprint $table) {
            $table->bigIncrements('assigned_cleaner_id');
            $table->String('status');
            $table->unsignedBigInteger('cleaner_id');
            $table->foreign('cleaner_id')->references('cleaner_id')->on('cleaners')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('booking_id')->on('bookings')
                    ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('assigned_cleaners');
    }
}
