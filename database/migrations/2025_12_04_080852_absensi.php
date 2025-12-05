<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();

            // relasi ke pegawai
            $table->unsignedBigInteger('id_pegawai');
            $table->foreign('id_pegawai')->references('id')->on('pegawai')->onDelete('cascade');

            // tanggal absensi
            $table->date('tanggal');

            // jam masuk & status
            $table->time('jam_masuk')->nullable();
            $table->enum('status_masuk', ['hadir', 'sakit', 'izin', 'alfa', 'cuti'])->nullable();
            $table->string('keterangan_masuk')->nullable();
            $table->string('foto_masuk')->nullable(); // simpan nama file saja

            // jam pulang & status
            $table->time('jam_pulang')->nullable();
            $table->enum('status_pulang', ['hadir', 'sakit', 'izin', 'alfa', 'cuti'])->nullable();
            $table->string('keterangan_pulang')->nullable();
            $table->string('foto_pulang')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
