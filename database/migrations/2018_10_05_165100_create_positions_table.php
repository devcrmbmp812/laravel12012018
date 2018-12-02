<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('position_id');
    $table->string('position_title')->unique();
    $table->string('position_status');
    $table->integer('program_id');
    $table->string('earnings_code');
    $table->string('district_code_id');
    $table->integer('supervisor_id');
    $table->string('wage_grade');
    $table->string('bc1')->nullable();
    $table->string('bc2')->nullable();
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
        Schema::dropIfExists('positions');
    }
}
