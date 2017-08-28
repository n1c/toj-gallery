<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImagesPath extends Migration
{
    public function up()
    {
        Schema::table('images', function ($table) {
            $table->string('path')->after('filename')->nullable();
        });
    }

    public function down()
    {
        // lol
    }
}
