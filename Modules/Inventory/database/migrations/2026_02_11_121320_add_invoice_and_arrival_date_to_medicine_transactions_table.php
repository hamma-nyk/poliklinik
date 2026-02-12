<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sc_inventory.medicine_transactions', function (Blueprint $table) {
            // Menambahkan kolom baru setelah transaction_date (opsional)
            $table->date('invoice_date')->nullable()->after('transaction_date')->comment('Tanggal Faktur Supplier');
            $table->date('arrival_date')->nullable()->after('invoice_date')->comment('Tanggal Barang Tiba di Gudang');
            
            // Opsional: Tambah kolom Nomor Faktur jika belum ada
            $table->string('invoice_number')->nullable()->after('id'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sc_inventory.medicine_transactions', function (Blueprint $table) {
            
        });
    }
};
