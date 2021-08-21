<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleanerReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaner_reviews', function (Blueprint $table) {
            $table->bigIncrements('cleaner_review_id');
            $table->String('cleaner_name');
            $table->unsignedBigInteger('review_id');
            $table->foreign('review_id')->references('review_id')->on('reviews')
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
        Schema::dropIfExists('cleaner_reviews');
    }
}
