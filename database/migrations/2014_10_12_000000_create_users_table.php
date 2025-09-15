<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('level');
            $table->string('status')->default('1');
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['name' => 'Administrator', 'username' => 'admin', 'password' => bcrypt('Admin2025'), 'level' => '1'],
            ['name' => 'Petugas', 'username' => 'petugas', 'password' => bcrypt('Petugas2025'), 'level' => '2'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
