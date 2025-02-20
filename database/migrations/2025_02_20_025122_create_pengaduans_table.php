<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('nama');
            $table->string('no_hp');
            $table->string('email');
            $table->text('alamat');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('bukti_file');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('alasan_penolakan')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->string('token')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
