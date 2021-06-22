<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_assigns', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('staff_id');
            // $table->string('role');
            $table->unsignedBigInteger('process_method_id')->nullable();
            $table->boolean('direct_report')->nullable();
            $table->text('sms')->nullable();
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
        Schema::dropIfExists('job_assigns');
    }
}
