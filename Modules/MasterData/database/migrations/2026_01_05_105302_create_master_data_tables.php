<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Dokter
        Schema::create('sc_master.doctors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable()->unique();
            $table->string('name');
            $table->string('nik_ktp')->unique()->comment('NIK Perusahaan/KTP');
            $table->string('sip')->nullable();
            $table->string('specialization')->default('Umum');
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Perawat
        Schema::create('sc_master.nurses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable()->unique();
            $table->string('name');
            $table->string('nik_ktp')->unique()->comment('NIK Perusahaan/KTP');
            $table->string('str')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Karyawan (Data Murni HR - Import CSV)
        Schema::create('sc_master.employees', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable()->unique();
            $table->string('nik')->unique()->comment('NIK Perusahaan');
            $table->string('nama')->nullable();
            $table->string('ktp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('phone')->nullable();
            $table->string('blood_type', 20)->nullable();
            $table->string('bag_dept')->nullable();
            $table->string('subbag_dept')->nullable();
            $table->string('sub_subbag_dept')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('gender', 1)->nullable(); 
            // Status Karyawan (NULL=Aktif, KO=Keluar)
            $table->string('is_active', 20)->nullable()->default(null);
            $table->timestamps();
        });

        // 4. Tabel Pasien (INI YANG BARU)
        // Semua yang berobat masuk sini.
        Schema::create('sc_master.patients', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable()->unique();
            // Identitas Pasien
            $table->string('nik_ktp')->nullable()->unique(); // Untuk pencarian umum
            $table->string('name');
            $table->string('gender', 1);
            $table->date('birth_date')->nullable();
            $table->text('alamat')->nullable();
            $table->string('phone')->nullable();
            
            // Info Medis Dasar
            $table->string('blood_type', 5)->nullable();
            $table->text('allergies')->nullable(); // Penting untuk medis

            // Kategori Pasien
            $table->enum('type', ['karyawan', 'keluarga', 'mitra', 'umum'])->default('umum');
            
            // RELASI KE KARYAWAN (Nullable)
            // Jika dia karyawan, isi ID-nya. Jika umum, biarkan NULL.
            $table->unsignedBigInteger('employee_id')->nullable();
            
            // Relasi ke Keluarga (Opsional: Jika ini istri karyawan, link ke ID karyawan suaminya)
            $table->unsignedBigInteger('family_of_employee_id')->nullable();

            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('employee_id')
                  ->references('id')->on('sc_master.employees')
                  ->onDelete('set null'); // Jika data HR dihapus, data pasien tetap ada (aman)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_master.patients'); // Hapus pasien dulu karena punya FK
        Schema::dropIfExists('sc_master.employees');
        Schema::dropIfExists('sc_master.nurses');
        Schema::dropIfExists('sc_master.doctors');
    }
};