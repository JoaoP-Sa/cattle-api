<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animals', function(Blueprint $table) {
            $table->float('milk')->default(0)->change();
            $table->boolean('shooted_down')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animals', function(Blueprint $table) {
            $table->boolean('shooted_down')->nullable(false)->default(null)->change();
            $table->float('milk')->nullable(false)->default(null)->change();
        });
    }
}
