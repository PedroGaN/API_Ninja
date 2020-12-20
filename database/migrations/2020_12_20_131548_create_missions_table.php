<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();

            $table->string('client_code', 100);
            $table->string('request', 400);
            $table->integer('stimated_ninjas')->default(1)->unsigned();
            $table->string('payment', 400);
            $table->enum('status', ['Pending', 'Ongoing', 'Successful', 'Failed'])->default('Pending');
            $table->boolean('URGENT')->default(false);

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
        Schema::dropIfExists('missions');
    }
}
