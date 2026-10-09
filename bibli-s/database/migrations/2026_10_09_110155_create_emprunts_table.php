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
       Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('book_id')
                  ->constrained('books')
                  ->onDelete('cascade');
            $table->date('loaned_at');
            $table->date('due_date');
            $table->date('returned_at')->nullable();
            $table->enum('status', ['en_cours', 'retourné', 'en_retard'])
                  ->default('en_cours');
            $table->timestamps();
        });
    }

   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunts');
    }
};
