<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Bagian (Department) - Contoh: TE
        Schema::create('sc_master.departments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // Kode: TE
            $table->string('name');               // Nama: Teknik
            $table->timestamps();
        });

        // 2. Tabel Sub Bagian - Contoh: PMP
        Schema::create('sc_master.sub_departments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // Kode: PMP
            $table->string('name');               // Nama: Pemper (Pemeliharaan Perbaikan?)
            // Opsional: Jika Sub Bagian terikat ke Bagian tertentu
            // $table->foreignId('department_id')->nullable(); 
            $table->timestamps();
        });

        // 3. Tabel Sub Sub Bagian
        Schema::create('sc_master.units', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->timestamps();
        });

        // 4. Tabel Jabatan - Contoh: OSDK
        Schema::create('sc_master.positions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // Kode: OSDK
            $table->string('name');               // Nama: Operator ...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_master.positions');
        Schema::dropIfExists('sc_master.units');
        Schema::dropIfExists('sc_master.sub_departments');
        Schema::dropIfExists('sc_master.departments');
    }
};