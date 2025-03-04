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
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('time');
            $table->string('food');
            $table->bigInteger('food_id');
            $table->string('serving_size');
            $table->float('carbohydrate')->default(0);
            $table->float('protein')->default(0);
            $table->float('fat')->default(0);
            $table->float('fiber')->default(0);
            $table->float('sugar')->default(0);
            $table->float('calorie')->default(0);
            $table->string('tips')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_plans');
    }
};
