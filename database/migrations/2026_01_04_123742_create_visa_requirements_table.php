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
        if (! Schema::hasTable('visa_requirements')) {
            Schema::create('visa_requirements', function (Blueprint $table) {
                $table->id();
                $table->string('country');
                $table->string('country_code', 3)->nullable();
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->json('required_documents'); // Array of required documents
                $table->text('application_guidelines')->nullable();
                $table->text('processing_time')->nullable();
                $table->decimal('visa_fee', 10, 2)->nullable();
                $table->string('currency', 3)->default('BDT');
                $table->text('eligibility_criteria')->nullable();
                $table->text('important_notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_requirements');
    }
};
