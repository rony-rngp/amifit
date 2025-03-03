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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('weight_unit', ['kg', 'pounds'])->nullable();
            $table->float('weight')->nullable();
            $table->enum('height_unit', ['cm', 'inches'])->nullable();
            $table->integer('height_cm')->nullable();
            $table->integer('height_feet')->nullable();
            $table->integer('height_inches')->nullable();
            $table->string('food_preference')->nullable();
            $table->string('food_preference_other')->nullable();
            $table->string('activity_level')->nullable();
            $table->string('desired_fitness_goals')->nullable();
            $table->string('desired_fitness_goals_other')->nullable();
            $table->string('pre_existing_medical_condition')->nullable();
            $table->string('current_medications')->nullable();
            $table->string('history_of_surgical_procedures')->nullable();
            $table->string('doctor_recommendations_for_exercise')->nullable();
            $table->integer('resting_heart_rate')->nullable();
            $table->integer('systolic')->nullable();
            $table->integer('diastolic')->nullable();

            $table->enum('prior_exercise_experience', ['yes', 'no'])->nullable();
            $table->enum('assess_to_gym_or_home_workout', ['gym', 'home', 'both', 'dont_know'])->nullable();
            $table->integer('weekly_commitment')->nullable();
            $table->string('preferred_workout_times')->nullable();
            $table->string('waist_measurement_unit')->nullable();
            $table->string('waist_measurement')->nullable();
            $table->string('hip_measurement_unit')->nullable();
            $table->integer('hip_measurement')->nullable();
            $table->string('chest_measurement_unit')->nullable();
            $table->integer('chest_measurement')->nullable();
            $table->string('neck_circumference_unit')->nullable();
            $table->integer('neck_circumference')->nullable();
            $table->integer('body_fat_percentage')->nullable();

            $table->string('any_dietary')->nullable();
            $table->integer('daily_sleep_duration')->nullable();
            $table->string('sleep_quality_assessment')->nullable();
            $table->string('occupational_activity_level')->nullable();
            $table->integer('number_of_steps_per_day')->nullable();
            $table->string('hydration_intake_unit')->nullable();
            $table->float('hydration_intake')->nullable();

            //fitness assessment
            $table->enum('can_you_perform_a_bodyweight_squat', ['yes', 'no', 'dont_know'])->nullable();
            $table->enum('can_you_perform_a_push_up', ['yes', 'no', 'dont_know'])->nullable();
            $table->enum('can_you_perform_a_pull_up', ['yes', 'no', 'dont_know'])->nullable();
            $table->string('max_reps_at_bodyweight')->nullable();
            $table->string('flexibility_assessment')->nullable();
            $table->string('range_of_motion_for_key_joints')->nullable();

            $table->integer('overhead')->nullable();
            $table->integer('squat')->nullable();
            $table->integer('toe_touch')->nullable();
            $table->integer('shoulder_rotation')->nullable();
            $table->integer('hip_flexion')->nullable();
            $table->integer('ankle_mobility')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
