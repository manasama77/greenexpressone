<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->string('from_master_area_name');
            $table->string('from_master_sub_area_name')->nullable();
            $table->string('to_master_area_name');
            $table->string('to_master_sub_area_name')->nullable();
            $table->string('vehicle_name');
            $table->string('vehicle_number');
            $table->dateTime('datetime_departure');
            $table->enum('schedule_type', ['shuttle', 'charter']);
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('qty_adult');
            $table->integer('qty_baby');
            $table->boolean('special_request')->default(false);
            $table->string('flight_number')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('luggage_qty');
            $table->decimal('luggage_price', 19, 2);
            $table->decimal('extra_price', 19, 2);
            $table->foreignId('voucher_id')->nullable(true)->constrained('vouchers')->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('promo_price', 19, 2);
            $table->decimal('base_price', 19, 2);
            $table->decimal('total_price', 19, 2);
            $table->enum('booking_status', ['pending', 'active', 'expired']);
            $table->enum('payment_status', ['waiting', 'paid', 'failed']);
            $table->string('payment_method')->nullable();
            $table->string('payment_token')->nullable();
            $table->decimal('total_payment', 19, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};