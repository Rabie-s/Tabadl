<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->tinyInteger('book_level')->default(1)->comment('diploma=>1|bachelors=>2');
            $table->tinyInteger('status')->default(1)->comment('offered=>1|wanted=>2');
            $table->tinyText('description')->nullable()->comment('Short description about this book');
            $table->boolean('active')->default(true);
            $table->boolean('done')->default(false);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
