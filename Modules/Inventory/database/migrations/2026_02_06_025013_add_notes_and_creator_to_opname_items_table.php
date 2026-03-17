<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sc_inventory.stock_opname_items', function (Blueprint $table) {
            // 1. Tambah kolom opname_notes setelah difference
            $table->text('opname_notes')->nullable()->after('difference');

            // 2. Tambah kolom created_by (Relasi ke tabel users)
            // Menggunakan name() untuk menghindari error identifier too long di Postgres
            $table->foreignId('created_by')
                  ->nullable() 
                  ->after('opname_notes')
                  ->constrained('public.users')
                  ->onDelete('set null')
                  ->name('so_items_created_by_foreign');
        });
    }

    public function down(): void
    {
        Schema::table('sc_inventory.stock_opname_items', function (Blueprint $table) {
            // Drop foreign key dulu, baru kolomnya
            $table->dropForeign('so_items_created_by_foreign');
            $table->dropColumn(['opname_notes', 'created_by']);
        });
    }
};