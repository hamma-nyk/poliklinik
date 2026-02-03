<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sc_master.nurses', function (Blueprint $table) {
            $table->foreignId('employee_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('sc_master.employees')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sc_master.nurses', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }
};