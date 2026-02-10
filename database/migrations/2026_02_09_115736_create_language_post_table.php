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
        Schema::create('language_post', function (Blueprint $table) {
        $table->id();
        
        // connect to post 
        $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade');
        
        // connect to question
        $table->foreignId('question_id')->nullable()->constrained()->onDelete('cascade');
        
        // connect to language
        $table->foreignId('language_id')->constrained()->onDelete('cascade');
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_post');
    }
};
