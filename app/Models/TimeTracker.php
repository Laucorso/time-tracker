<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTracker extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getDurationAttribute()
    {
        if ($this->end_time) {
            return $this->end_time->diffInMinutes($this->start_time);
        }

        return 0;
    }
}
