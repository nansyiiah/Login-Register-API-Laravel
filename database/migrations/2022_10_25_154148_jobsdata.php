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
        Schema::create('jobs_data', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('position');
            $table->string('salary');
            $table->string('koordinat');
            $table->string('lokasi');
            $table->string('gender');
            $table->string('image_url');
            $table->string('pelamar');
            $table->rememberToken();
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
        //
    }
};
