<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Perintah SQL Native untuk membuat schema
        DB::statement('CREATE SCHEMA IF NOT EXISTS sc_master');
        DB::statement('CREATE SCHEMA IF NOT EXISTS sc_inventory');
        DB::statement('CREATE SCHEMA IF NOT EXISTS sc_clinical');
    }

    public function down(): void
    {
        // Hati-hati, ini akan menghapus semua tabel di dalamnya
        DB::statement('DROP SCHEMA IF EXISTS sc_master CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS sc_inventory CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS sc_clinical CASCADE');
    }
};