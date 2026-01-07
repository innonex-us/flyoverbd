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
        if (! Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
                $table->string('booking_reference')->unique();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone');
                $table->text('customer_address')->nullable();
                $table->integer('number_of_participants')->default(1);
                $table->json('participants')->nullable(); // Array of participant details
                $table->date('travel_date')->nullable();
                $table->decimal('total_amount', 10, 2);
                $table->decimal('paid_amount', 10, 2)->default(0);
                $table->string('currency', 3)->default('BDT');
                $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
                $table->enum('booking_status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
                $table->text('special_requests')->nullable();
                $table->text('admin_notes')->nullable();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamp('confirmed_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
