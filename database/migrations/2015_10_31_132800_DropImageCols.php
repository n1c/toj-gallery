<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropImageCols extends Migration
{
    public function up()
    {
        Schema::table('images', function ($table) {
            $table->dropColumn('host_id');
            $table->dropColumn('filename');
        });
    }

    public function down()
    {
        // Nah
    }
}
