<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();

            // FK ke member_sip, boleh null
            $table->foreignId('id_member_sip')
                  ->nullable()
                  ->constrained('member_sip')
                  ->onDelete('cascade');

            // FK ke metode_pembayarans, boleh null
            $table->foreignId('id_metode_pembayaran')
                  ->nullable()
                  ->constrained('metode_pembayarans')
                  ->onDelete('cascade');

             // FK ke metode_pembayarans, boleh null
            $table->foreignId('id_lokasi')
                  ->nullable()
                  ->constrained('lokasi')
                  ->onDelete('cascade');
            // FK ke metode_pembayarans, boleh null
            $table->foreignId('id_petugas')
                  ->nullable()
                  ->constrained('petugas')
                  ->onDelete('cascade');

             // FK ke metode_pembayarans, boleh null
            $table->foreignId('id_jenis_kendaraan')
                  ->nullable()
                  ->constrained('jenis_kendaraan')
                  ->onDelete('cascade');
            $table->date('tarif');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('nopol', 20);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['sudah_bayar', 'belum_bayar'])->default('belum_bayar');

            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengunjung');
    }
};
