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
        Schema::create('master_special_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_sub_area_id')->constrained();
            $table->decimal('first_person_price', 19, 2, true);
            $table->decimal('extra_person_price', 19, 2, true);
            $table->enum('is_active', ['yes', 'no']);
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
        Schema::dropIfExists('master_special_areas');
    }
};
