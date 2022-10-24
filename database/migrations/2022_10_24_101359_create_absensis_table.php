<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('lokasi_kerja');
            $table->longText('surat_tugas')->nullable();
            $table->char('suhu', 3);
            $table->json('gejala_harian');
            $table->unsignedBigInteger('user_id');
            $table->json('clock_in');
            $table->json('clock_out');
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
        Schema::dropIfExists('absensis');
    }
}
