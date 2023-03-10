<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturerables', function (Blueprint $table) {
            $table->foreignId('lecturer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->morphs('lecturerable');
            $table->enum('status', ['Utama', 'Pilihan', 'Pembimbing 1', 'Pembimbing 2', 'Penguji 1', 'Penguji 2', 'Penguji 3']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturerables');
    }
}
