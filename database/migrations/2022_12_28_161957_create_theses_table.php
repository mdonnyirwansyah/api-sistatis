<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('register_date');
            $table->string('title');
            $table->foreignId('field_id')->nullable()->constrained('fields', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('semester');
            $table->date('finish_date')->nullable();
            $table->enum('status', ['Pendaftaran Tugas Akhir', 'Seminar Proposal Tugas Akhir', 'Seminar Hasil Tugas Akhir', 'Sidang Tugas Akhir'])->default('Pendaftaran Tugas Akhir');
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
        Schema::dropIfExists('theses');
    }
}
