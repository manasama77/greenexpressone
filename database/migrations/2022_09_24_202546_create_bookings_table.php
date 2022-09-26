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
            $table->foreignId('schedule_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('from_id');
            $table->string('from_table');
            $table->string('from_name');
            $table->integer('to_id');
            $table->string('to_table');
            $table->string('to_name');
            $table->foreignId('vehicle_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('vehicle_name');
            $table->string('vehicle_number');
            $table->dateTime('datetime_departure');
            $table->dateTime('datetime_arrival');
            $table->enum('schedule_type', ['one way', 'charter']);
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('qty_adult');
            $table->integer('qty_baby');
            $table->enum('is_extra', ['yes', 'no']);
            $table->string('flight_number')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('luggage_qty');
            $table->decimal('luggage_price', 19, 2);
            $table->decimal('extra_price', 19, 2);
            $table->foreignId('voucher_id')->nullable(true)->constrained('vehicles')->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('promo_price', 19, 2);
            $table->decimal('total_price', 19, 2);
            $table->enum('booking_status', ['active', 'used', 'waiting payment', 'expired']);
            $table->string('payment_method')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('payment_status')->nullable();
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
