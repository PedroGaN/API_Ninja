<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNinjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ninjas', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->enum('rank', ['Genin', 'Chunin', 'Jonin', 'Kage'])->default('Genin');
            $table->string('skill_inform', 400);
            $table->enum('status', ['Active', 'Former', 'Deceased', 'Deserter'])->default('Active');

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
        Schema::dropIfExists('ninjas');
    }
}
