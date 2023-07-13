<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_sponsorship', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
            $table->unsignedBigInteger('sponsorship_id');
            $table->foreign('sponsorship_id')->references('id')->on('sponsorships')->cascadeOnDelete();
            $table->primary(['doctor_id','sponsorship_id']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_sponsorship');
    }
};
