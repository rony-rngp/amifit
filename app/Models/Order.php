<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'plan_info' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function diet_plans()
    {
        return $this->hasMany(DietPlan::class);
    }

    public function workout_plans()
    {
        return $this->hasMany(WorkoutPlan::class);
    }

}
