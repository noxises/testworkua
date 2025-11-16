<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlsTable extends Migration
{
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('original_url');
            $table->string('short_code', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('short_urls');
    }
}
