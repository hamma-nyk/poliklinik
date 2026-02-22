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
       Schema::table('users', function (Blueprint $table) {
        // Tambahkan nullable dulu agar kolom bisa dibuat meskipun ada data lama
        $table->string('username')->nullable()->unique()->after('name');
        });

        // Isi data username yang masih kosong (NULL) diambil dari bagian depan email
        // Misal: eko@gmail.com menjadi username 'eko'
        DB::table('users')->whereNull('username')->update([
            'username' => DB::raw("split_part(email, '@', 1)")
        ]);

        // Setelah semua terisi, baru paksa menjadi NOT NULL
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
