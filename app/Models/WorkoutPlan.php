<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
