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
    $table->foreignId('user_id')->constrained('users');  
    $table->foreignId('book_id')->constrained('livres');
    $table->string('borrower_name');                     
    $table->string('borrower_phone')->nullable();
    $table->string('borrower_email')->nullable();
    $table->date('loaned_at');
    $table->date('due_date');
    $table->date('returned_at')->nullable();
    $table->string('status')->default('en_cours');
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
