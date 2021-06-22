<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyContraintsToJobAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_assigns', function (Blueprint $table) {
            $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('staff_id')->references('id')->on('staff')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('process_method_id')->references('id')->on('process_methods')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_assigns', function (Blueprint $table) {
            $table->dropConstrainedForeignId('job_id');
            $table->dropConstrainedForeignId('staff_id');
        });
    }
}
