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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('plan_id');
            $table->text('plan_info');
            $table->integer('discount')->default(0);
            $table->float('monthly_price');
            $table->integer('duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('guideline')->nullable();
            $table->text('motivational_boost')->nullable();
            $table->text('today_win')->nullable();
            $table->text('focus_area')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
