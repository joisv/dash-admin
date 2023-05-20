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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('slug')->unique();
            $table->enum('type', ['Movie', 'Tv']);
            $table->string('score');
            $table->string('status');
            $table->integer('year')->nullable();
            $table->string('season')->nullable();
            $table->longText('synopsis')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('image')->nullable();
            $table->integer('views')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
