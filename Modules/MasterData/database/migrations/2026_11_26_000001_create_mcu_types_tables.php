<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sc_master.mcu_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('recommended_exams')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('sc_master.mcu_type_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mcu_type_id');
            $table->unsignedBigInteger('diagnosis_id');
            $table->timestamps();

            $table->foreign('mcu_type_id')
                ->references('id')->on('sc_master.mcu_types')
                ->onDelete('cascade');

            $table->foreign('diagnosis_id')
                ->references('id')->on('sc_master.diagnoses')
                ->onDelete('cascade');

            $table->unique(['mcu_type_id', 'diagnosis_id'], 'mcu_type_diag_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_master.mcu_type_diagnosis');
        Schema::dropIfExists('sc_master.mcu_types');
    }
};
