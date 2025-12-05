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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();

            // relasi ke user
            $table->unsignedBigInteger('id_user');

            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('contact')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();

            // foreign key ke users
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // jika user dihapus, otomatis hapus pegawai
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
};
