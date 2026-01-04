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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('itinerary')->nullable();
            $table->text('highlights')->nullable();
            $table->json('images')->nullable(); // Array of image paths
            $table->string('thumbnail')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('BDT');
            $table->integer('duration_days');
            $table->string('destination')->nullable();
            $table->string('departure_location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('min_participants')->default(1);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('included')->nullable(); // What's included
            $table->text('excluded')->nullable(); // What's excluded
            $table->text('terms_conditions')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
