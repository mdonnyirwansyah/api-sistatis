<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiefOfExaminersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chief_of_examiners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminar_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lecturer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('chief_of_examiners');
    }
}
