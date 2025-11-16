<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlStatsTable extends Migration
{
    public function up()
    {
        Schema::create('short_url_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('short_url_id');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('short_url_id')->references('id')->on('short_urls')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('short_url_stats');
    }
}
