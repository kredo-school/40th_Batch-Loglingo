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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // 誰が report したか
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // report 対象（post or comment /question or answer）
            $table->unsignedBigInteger('reportable_id');
            $table->string('reportable_type');

            $table->timestamps();

            // 1人が同じ対象を2回 report できないようにする
            $table->unique(['user_id', 'reportable_id', 'reportable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');

    }
};

