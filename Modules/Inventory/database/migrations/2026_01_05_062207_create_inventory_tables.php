<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Master Obat
        Schema::create('sc_inventory.medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // OB202601001
            $table->string('name');
            $table->string('unit')->default('pcs'); // strip, botol, tablet
            $table->decimal('price', 15, 2)->default(0); // Harga Jual
            $table->integer('current_stock')->default(0); // Stok saat ini (Update otomatis)
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Tabel Transaksi Obat (Log keluar masuk)
        Schema::create('sc_inventory.medicine_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // OBI... (In) atau OBO... (Out)
            $table->enum('type', ['in', 'out']); // Masuk (Pembelian) atau Keluar (Pasien)
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            
            // Relasi optional: Bisa dari Vendor (Pembelian) atau ke Pasien (Rekam Medis)
            // Kita buat nullable dulu biar fleksibel
            $table->unsignedBigInteger('medical_record_id')->nullable(); 
            
            $table->timestamps();
        });

        // 3. Tabel Detail Item Transaksi (Pivot)
        Schema::create('sc_inventory.medicine_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_transaction_id')->constrained('sc_inventory.medicine_transactions')->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained('sc_inventory.medicines')->onDelete('restrict');
            
            $table->integer('quantity');
            $table->decimal('price_at_moment', 15, 2)->default(0); // Harga saat transaksi terjadi (PENTING untuk Laporan)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_inventory.medicine_transaction_items');
        Schema::dropIfExists('sc_inventory.medicine_transactions');
        Schema::dropIfExists('sc_inventory.medicines');
    }
};