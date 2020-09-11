<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('nim')->nullable();
            $table->string('tahun')->nullable();
            $table->string('kelas')->nullable();
            $table->string('gender')->nullable();
            $table->text('alamat')->nullable();
        });

        Schema::create('dosens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('nik')->nullable();
            $table->text('alamat')->nullable();
            $table->string('gender')->nullable();
            $table->string('no_hp')->nullable();
        });

        Schema::create('matkuls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->integer('sks');
            $table->text('deskripsi')->nullable();
            // $table->timestamps();
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mahasiswa_id');
            $table->bigInteger('jadwal_id');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('jadwals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('matkul_id');
            $table->unsignedBigInteger('dosen_id');
            $table->string('room')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('kode_absen')->nullable();
            $table->string('start_at')->nullable();
            $table->string('finish_at')->nullable();
            $table->timestamps();
        });

        Schema::create('dosen_has_matkuls', function (Blueprint $table) {
            $table->unsignedBigInteger('matkul_id');
            $table->unsignedBigInteger('dosen_id');

            $table->foreign('matkul_id')->references('id')->on('matkuls')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');

            $table->primary(['matkul_id', 'dosen_id'], 'dosen_has_matkuls_matkul_id_dosen_id_primary');
        });

        Schema::create('mahasiswa_has_jadwals', function (Blueprint $table) {
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('mahasiswa_id');

            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');

            $table->primary(['jadwal_id', 'mahasiswa_id'], 'mahasiswa_has_jadwals_jadwal_id_mahasiswa_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_has_matkuls');
        Schema::dropIfExists('mahasiswa_has_jadwals');
        Schema::dropIfExists('mahasiswas');
        Schema::dropIfExists('dosens');
        Schema::dropIfExists('matkuls');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('jadwals');
    }
}
