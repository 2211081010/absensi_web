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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();

            // relasi ke kantor
            $table->unsignedBigInteger('id_kantor')->nullable();

            $table->string('nama');
            $table->string('nohp');
            $table->string('foto')->nullable();

            $table->timestamps();

            // foreign key ke kantor
            $table->foreign('id_kantor')
                  ->references('id')
                  ->on('kantor')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petugas');
    }
};
