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
    Schema::table('sc_inventory.medicines', function (Blueprint $table) {
        // 1. Ini untuk created_at & updated_at (Waktu)
        // Jika tabel Anda belum punya ini, uncomment baris di bawah:
        // $table->timestamps(); 
        
        // 2. Ini untuk created_by & updated_by (User ID)
        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
    });
}

public function down()
{
    Schema::table('sc_inventory.medicines', function (Blueprint $table) {
        // $table->dropTimestamps(); // Hapus ini jika tadi di-uncomment
        $table->dropForeign(['created_by']);
        $table->dropForeign(['updated_by']);
        $table->dropColumn(['created_by', 'updated_by']);
    });
}

    /**
     * Reverse the migrations.
     */
    
};
