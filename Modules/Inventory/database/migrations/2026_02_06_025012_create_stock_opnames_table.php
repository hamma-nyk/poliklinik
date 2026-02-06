<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Header (Data Utama Opname)
        Schema::create('sc_inventory.stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('opname_number')->unique(); // Contoh: SO-2601-001
            $table->date('opname_date');
            $table->text('notes')->nullable();
            
            // User pembuat (Relasi ke tabel users utama/public)
            $table->foreignId('created_by')->constrained('public.users'); 
            // Catatan: sesuaikan 'public.users' jika schema user Anda berbeda
            
            $table->timestamps();
        });

        // 2. Tabel Detail Item (Riwayat Fisik vs Sistem)
        Schema::create('sc_inventory.stock_opname_items', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Header
            $table->foreignId('stock_opname_id')
                  ->constrained('sc_inventory.stock_opnames')
                  ->onDelete('cascade');
            
            // Relasi ke Obat
            $table->foreignId('medicine_id')
                  ->constrained('sc_inventory.medicines');
            
            $table->integer('system_stock');   // Stok di komputer sebelum opname
            $table->integer('physical_stock'); // Stok fisik inputan user
            $table->integer('difference');     // Selisih (Fisik - Sistem)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_inventory.stock_opname_items');
        Schema::dropIfExists('sc_inventory.stock_opnames');
    }
};