<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->date('register_date');
            $table->foreignId('thesis_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('name', ['Seminar Proposal Tugas Akhir', 'Seminar Hasil Tugas Akhir', 'Sidang Tugas Akhir']);
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('semester');
            $table->enum('status', ['Registered', 'Scheduled', 'Validated']);
            $table->string('url_file_undangan')->nullable();
            $table->string('url_file_berita_acara')->nullable();
            $table->date('validate_date')->nullable();
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
        Schema::dropIfExists('seminars');
    }
}
