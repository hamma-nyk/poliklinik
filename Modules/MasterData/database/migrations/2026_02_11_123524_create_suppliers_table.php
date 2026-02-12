<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sc_master.suppliers', function (Blueprint $table) {
            $table->id();
            
            // Data Utama
            $table->string('name'); // Nama PT/Toko Supplier
            $table->string('code')->nullable()->unique(); // Kode Supplier (misal: SUP-001)
            
            // Kontak
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable(); // Nama Sales/CP
            
            // Alamat
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            
            // System
            $table->timestamps();
            $table->softDeletes(); // Penting: Agar data tidak hilang permanen
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_master.suppliers');
    }
};