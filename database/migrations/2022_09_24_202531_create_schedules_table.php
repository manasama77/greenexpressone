<?php

use App\Models\Vehicle;
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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('from_id');
            $table->string('from_table');
            $table->integer('to_id');
            $table->string('to_table');
            $table->foreignIdFor(Vehicle::class)->constrained();
            $table->dateTime('datetime_departure');
            $table->dateTime('datetime_arrival');
            $table->enum('schedule_type', ['one way', 'charter']);
            $table->enum('is_active', ['yes', 'no']);
            $table->string('photo')->nullable();
            $table->decimal('normal_price', 19, 2);
            $table->string('driver_contact')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('schedules');
    }
};
